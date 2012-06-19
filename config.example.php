<?php

$environment = array
(
    'url' => array
    (
        /**
         * Only set if sitecmd is unable to determine the correct URL for this site.
         * Please specify the full URL (including http:// but no trailing slash).
         */
        'root' => NULL,
        /**
         * The SSL domain for your website (e.g. https://www.example.com).
         *
         * This should only be used if you have an SSL certificate
         * and it should point to this sitecmd instance (not somewhere else).
         *
         * Please include the 'https://' prefix but no trailing slash.
         */
        'ssl' => NULL,
        /**
         * Whether to append or remove trailing forward-slashes to URLs.
         *
         * This may appear to slow down your website, as the visitor's
         * browser will be redirected to the new location, loading the page
         * again, but in most cases this slow down should be negligible.
         *
         * Internally, sitecmd will create URLs with or without the trailing
         * slash based upon this setting.
         */
         'slashes' => TRUE,
         /**
          * Any file extensions to ignore.
          *
          * These are useful if you are using sitecmd with an existing website
          * that uses real (or virtual) file extensions in the URL.
          *
          * An example would be /about.php, /about.html, and so on. If you add
          * 'php' and 'html' to the array below, sitecmd will redirect any
          * requests matching those extensions to the usual extension-less
          * version.
          *
          * Please do not prefix the extensions with a dot.
          */
          'extensions' => array(),
        /**
         * URL routes.
         *
         * Routes listed below should be relative to your root URL, with no leading
         * or trailing slashes.
         */
        'routes' => array
        (
            '_default' => 'index',
            'task/:id' => 'task',
            'note/:id' => 'note',
        ),
    ),
    'paths' => array
    (
        /**
         * The absolute path to your website's PHP files.
         *
         * Note that this needs to point to the directory that contains the
         * PHP files that sitecmd will run. In most cases, this will be a
         * directory outside your public web directory.
         */
        'root' => dirname(__FILE__).DIRECTORY_SEPARATOR.'rare',
        /**
         * The absolute path and filename of your events file.
         *
         * This file is included near the start of execution, and should
         * contain any event hooks that you wish to use.
         */
        'events' => dirname(__FILE__).DIRECTORY_SEPARATOR.'common.php',
    ),
    'error' => array
    (
        /**
         * How to handle errors with Flourish.
         *
         * See http://flourishlib.com/docs/fCore#ErrorExceptionHandling
         */
        'errors' => 'html',
        /**
         * What error level to use throughout sitecmd.
         *
         * See www.php.net/manual/en/function.error-reporting.php
         *
         * Setting to 0 (zero) is suggested for production use.
         */
        'level' => -1,
        /**
         * How to handle exceptions with Flourish.
         *
         * See http://flourishlib.com/docs/fCore#ErrorExceptionHandling
         */
        'exceptions' => 'html',
        /**
         * Whether to show superglobal context error/exception output.
         *
         * It's suggested to set this to FALSE for production use.
         */
        'context' => FALSE,
        /**
         * Whether to enable Flourish's debugging mode.
         *
         * See http://flourishlib.com/docs/fCore#Debugging
         */
        'debug' => FALSE,
        /**
         * The file to log errors and/or exceptions to.
         *
         * Please specify an absolute path and ensure the file is writeable.
         */
        'file' => NULL,
        /**
         * Email recipient(s).
         */
         'mail' => array(),
    ),
    /**
     * Optional settings for controlling Flourish.
     */
    'flourish' => array
    (
        /**
         * How to load the Flourish libraries.
         *
         * Valid values are 'eager' or 'lazy', with NULL representing 'best'.
         *
         * See: http://flourishlib.com/docs/fLoader
         */
        'loader' => NULL,
    ),
    /**
     * Set these values if you would like to send mail through a remote mail
     * server.
     *
     * This will be used for error reporting if errors or exceptions are set
     * to report via email.
     *
     * These values are also available for you to use in your own code
     * if required via sitecmd::get('mail.host'), etc.
     */
    'mail' => array
    (
        'host'     => NULL,  // The mail server to connect to
        'port'     => 25,    // The port number to use
        'secure'   => FALSE, // Use a secure connection?
        'timeout'  => NULL,  // Defaults to php.ini's 'default_socket_timeout'
        'username' => NULL,  // If authentication is required
        'password' => NULL,  // If authentication is required
        'from'     => NULL,  // A 'From' email address
    ),
    'rare' => array
    (
        'db' => array
        (
            'hostname' => 'localhost',
            'database' => '',
            'username' => '',
            'password' => '',
        ),
        'default' => array
        (
            'priority' => 2, // Which priority to use by default
            'status' => 1, // Which status to use by default
            'assignee' => 1, // The DB ID of the user to use for non-assigned tasks
            // Mail sender details used for notification emails
            'from_name' => 'Rare Tasks',
            'from_email' => 'no-reply@example.com',
        ),
    ),
);