<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'portfoliodb';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * PHP mailer email
     * @var string
     */
    const MAILER_EMAIL = '';

    /**
     * PHP mailer password
     * @var string
     */
    const MAILER_PASS = '';
    /**
     * Reciver email
     * @var string
     */
    const RECIVER_EMAIL = 'mouiguinasimo@gmail.com';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;
}