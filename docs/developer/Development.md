# Development
Sudu is a single page application with a laravel powered API back end. The front end is made with vue.js.

## Getting started
After you cloned the repository, run the following commands in the project root to install the dependencies and build the assets:
- `composer install`
- `npm install`
- `run npm dev` or `npm run watch`

## Clone the code
Sudu is hosted on publicly on [Github](https://github.com/Digital-Peak/Sudu). You can fork it and adapt it to your needs.

## Submit changes
If you made some changes to your fork, feel free to create a pull request to the main repo if you want to contribute it to the community.

## Build your own package
Run the command `./build.sh` in the root folder. It creates a tmp folder with the required setup for production.
If you want to create a zip file, run `./build.sh 0.0.1`, where the first argument is a version string. It creates then a zip file in the project root folder with the name _Sudu-0.0.1.zip_.

## Run tests
To ensure a good code quality, Sudu has some automated tests which can be run with the command `vendor/bin/phpunit` or when you want to create a code coverage `composer test`.
