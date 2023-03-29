# OpenMMA
Open source member management and administration & event planning webapp

## Development
To set up a development environment, you will need the following prerequisites:
- php >=8.1
- composer >=2.5
- mariadb-server (or another laravel-supported database)

    A quick way to set up a database is using docker:
    ```
    docker run -e MARIADB_ROOT_PASSWORD=password -p 3306:3306 mariadb
    ```

Once you have these prerequisites installed, you can follow these steps to get
started:

1. Install the required php libraries
    ```
    composer install
    ```

2. Copy `.env.example` to `.env` and configure the database connection and mailer.

3. Set up the database
    ```
    php artisan migrate
    ```

4. Load some test data
    ```
    php artisan db:seed
    ```

5. Start the server
    ```
    php artisan serve
    ```
    The first time you open the site, you will need to generate an app key.


## Troubleshooting

### Images are not loading
The image storage directory needs to be linked to the public directory
```
php artisan storage:link
```