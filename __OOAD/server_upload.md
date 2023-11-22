# GRC (Governance, Risk, and Compliance)

## Prerequisites
* extension=php_ldap.dll (Using Apache Server: Search for extension=php_ldap.dll or extension=ldap in php.ini file. Uncomment this line, if not present then add this line in the file and save the file. Then restart your server)

## Run the project
1. Clone repository

    Via Terminal
    ```
        git clone https://github.com/pksystemsadmin/grc.git
        cd grc
        composer install
        cp .env.example .env
    ```
2. Database 

    2.1 Create a database with the name `GRC`

    2.2 Database Configuration in .env file in the application root
    ``` 
        DB_DATABASE=GRC
        DB_USERNAME=
        DB_PASSWORD=
        Put your database user after DB_USERNAME, and your user password after DB_PASSWORD
    ```
    2.3 Migrate & seed
    ``` 
        php artisan migrate --seed
    ```
    2.4 
    ```
        php artisan storage:link
    ```
    2.5 Run the project
    ```
        php artisan serve
    ```
3. Licence Key
    
    Via Terminal
    ```
        echo -n "cyber-mode" > vendor/laravel/framework/src/Illuminate/Encryption/t
        echo -n "cyber-mode" > vendor/laravel/framework/src/Illuminate/Encryption/ed
        echo -n "cyber-mode" > vendor/laravel/framework/src/Illuminate/Encryption/am
    ```
    Create a company in GRC management then you will get the application key and use it to set APP_KEY in .env
    
    Create a license key in GRC management then you will get a validation code and use it to activate the software

4. permissions
   
    Via Terminal
    ```
    // Laravel permissions
    sudo chown -R bitnami:daemon /opt/bitnami/apache/htdocs/grc;
    sudo chmod -R 775 /opt/bitnami/apache/htdocs/grc/storage;
    sudo chmod -R 775 /opt/bitnami/apache/htdocs/grc/bootstrap/cache;

    // Serials files permission
    sudo chown bitnami:daemon /opt/bitnami/apache/htdocs/grc/vendor/laravel/framework/src/Illuminate/Encryption/t ;
    sudo chmod 664 /opt/bitnami/apache/htdocs/grc/vendor/laravel/framework/src/Illuminate/Encryption/t ;
    sudo chown bitnami:daemon /opt/bitnami/apache/htdocs/grc/vendor/laravel/framework/src/Illuminate/Encryption/am ;
    sudo chmod 664 /opt/bitnami/apache/htdocs/grc/vendor/laravel/framework/src/Illuminate/Encryption/am ;
    sudo chown bitnami:daemon /opt/bitnami/apache/htdocs/grc/vendor/laravel/framework/src/Illuminate/Encryption/ed ;
    sudo chmod 664 /opt/bitnami/apache/htdocs/grc/vendor/laravel/framework/src/Illuminate/Encryption/ed ;
    ```
---
## License
GRC application Copyright © 2022-2023 PK company.
