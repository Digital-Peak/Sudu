# Sudu
A simple image gallery app made for performance.

## Images
Put your images into the folder public/images.

## Setup
Before Sudu can be used, you need to install the PHP and Javascript dependencies. After that the assets need to be built.

### Install PHP dependencies
Run `composer install` in the root folder. It creates a vendor directory with the PHP dependencies. If you want to build it for production, run `composer install --optimize-autoloader --no-dev`.

### Install Javascript dependencies
Run `npm install` in the root folder. It creates a node_modules directory with the Javascript dependencies. 

### Build the assets
If you want to build the assets, run `run npm dev` and for production `npm run prod`.

## Configuration
Copy the .env.sample to .env and adapt it to your needs.

## Build for production
Run the command `./build.sh` in the root folder. It creates a tmp folder with the required setup for production. It needs a .env.production file in the root folder which defines the production environment.
If you want to create a zip file, run `./build.sh 0.0.1`, where the first argument is a version string. It creates then a zip file in the projects folder with the name _Sudu-0.0.1.zip_.

## Progressive web app
Progressive web apps are installable web pages. Sudu supports that feature. All you have to do is to rename the file _/public/manifest.sample.json_ to _/public/manifest.json_ and adapt it to your needs. Important part is that the start url matches your web site url where the app is installed.
