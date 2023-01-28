<?php
return (object) array(
    /* Database connection settings */
    'db' => array(
        'mysql_host'     => '',
        'mysql_db'       => '',
        'mysql_user'     => '',
        'mysql_pass'     => '',
        'mysql_charset'  => 'utf8mb4',

        /* Session settings */
        'session_timeout' => 60 * 60 * 24 * 30, // 30 days
    ),

    /* Mailer e-mail account settings */
    'mailer' => array(
        'host'      => '',
        'port'      => 25,
        'username'  => '',
        'password'  => ''
    )
);