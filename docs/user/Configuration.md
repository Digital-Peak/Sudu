# Configuration
Sudu works out of the box without any configuration steps needed. There are still some options to change which are explained below. All the configuration options are stored in a _.env_ file. Initially this file doesn't exist as Sudu runs perfectly with the default options. All possible options are explained on the [laravel documentation page](https://laravel.com/docs/8.x).

To get you started, copy the .env.sample to .env and adapt it to your needs.

## Application name
Key: APP_NAME
Default: Gallery
Description: The application name which is used in the title of the web page.

## Images folder
Key: APP_IMAGES_DIR
Default: images
Description: The images folder, relative to the public directory.

## Locale
Key: APP_LOCALE
Default: en
Description: The default locale for strings.

## Fallback locale
Key: APP_FALLBACK_LOCALE
Default: en
Description: The fallback locale for strings.

## Debug mode
Key: APP_DEBUG
Default: false
Description: Can be true or false. Only activate when not on a public web site.

## Log level
Key: LOG_LEVEL
Default: warning
Description: The possible levels are from least severe to most severe: debug, info, notice, warning, error, critical, alert, emergency.

## Session lifetime
Key: SESSION_LIFETIME
Default: 120
Description: The lifetime of a session for web requests. 

## Database file location
Key: DB_DATABASE
Default: database/database.sqlite
Description: The path to the database file.

## Database connection
Key: DB_CONNECTION
Default: sqlite
Description: The database connection. Possible options are: sqlite, mysql, pgsql, sqlsrv

## Database driver
Initially SQLite is used for DB interactions. If you want to use another one, then change the following settings:
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=mysecret
