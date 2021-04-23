#!/bin/bash
# @package   Sudu
# @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
# @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL

if [ -d tmp ]; then
	rm -rf tmp
fi

mkdir tmp
cp -r bootstrap tmp
cp -r config tmp
cp -r database tmp
cp -r resources tmp
cp -r routes tmp
cp -r src tmp
cp -r storage tmp
cp composer.json tmp
cp composer.lock tmp
cp package.json tmp
cp package-lock.json tmp
cp webpack.mix.js tmp
cp .htaccess tmp

cd tmp

rm -rf bootstrap/cache/*
rm -rf storage/logs/*
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
rm -rf database/database.sqlite

if [ ! -z $1 ]; then
  sed -i "s/__DEPLOY_VERSION__/$1/g" .env
  sed -i "s/__DEPLOY_VERSION__/$1/g" config/app.php
fi

composer install --optimize-autoloader --no-dev

npm install
npm run prod

rm composer.json
rm composer.lock
rm package.json
rm package-lock.json
rm webpack.mix.js
rm -rf node_modules
rm -rf resources/js
rm -rf resources/lang
rm -rf resources/sass
rm -rf resources/web

if [ -z $1 ]; then
  exit
fi

rm -f ../Sudu-$1.zip
zip -rq ../Sudu-$1.zip .
cd ..
rm -rf tmp
