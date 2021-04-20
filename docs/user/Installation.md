# Installation
Sudu is pretty simple to install. All you need is a web server and a browser. No complicated installation routines.

## Download
The latest releases of Sudu can be downloaded from the [official releases page](https://github.com/Digital-Peak/Sudu/releases/latest).

## Upload to webserver
After you did grab it from the release page you have to unpack the zip file and upload it to a web server.

## SSH install in terminal
Log in on your web server by SSH and change to the directory you want to install Sudu. Then execute the following command:

`LOCATION=$(curl -s https://api.github.com/repos/Digital-Peak/Sudu/releases/latest \
| grep "tag_name" \
| awk '{print "https://github.com/Digital-Peak/Sudu/archive/" substr($2, 2, length($2)-3) ".zip"}') \
; curl -L -o Sudu.zip $LOCATION`

As next step extract the file Sudu.zip.

`unzip Sudu.zip`

## Install it fresh from the oven
Want to grab the latest code? Either [clone the repo](https://github.com/Digital-Peak/Sudu.git) or download it from [here](https://github.com/Digital-Peak/Sudu/archive/refs/heads/main.zip).

Before Sudu can be used, you need to install the PHP and Javascript dependencies and as last step, build the assets.

### Install PHP dependencies
Run `composer install` in the root folder. It creates a vendor directory with the PHP dependencies. If you want to build it for production, run `composer install --optimize-autoloader --no-dev`.

### Install Javascript dependencies
Run `npm install` in the root folder. It creates a node_modules directory with the Javascript dependencies.

### Build the assets
If you want to build the assets, run `run npm dev` and for production `npm run prod`.
