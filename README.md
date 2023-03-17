# OpenMMA
Open source member management and administration & event planning webapp

## Development
To set up a development environment, you will need the following prerequisites:
- php >=8.1
- composer >=2.5
- mariadb-server (or another laravel-supported database)

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

4. Start the server
    ```
    php artisan serve
    ```
    The first time you open the site, you will need to generate an app key.