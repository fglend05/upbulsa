<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {

    define('DBNAME', 'bulsa');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', '');

    define('ROOT', 'http://localhost/mvcphp/public');
} else {
    define('ROOT', '');
    define('DBNAME', '');
    define('DBHOST', '');
    define('DBUSER', '');
    define('DBPASS', '');
    define('DBDRIVER', '');

    echo "no local database";
}

// define('ROOT', 'https://lspu.edu.ph/e-sentry/api/public');
// define('DBNAME', 'lspuedu_clsd');
// define('DBHOST', 'localhost');
// define('DBUSER', 'lspuedu_clsd');
// define('DBPASS', 'LSPUCLSD2023');
// define('DBDRIVER', '');

define('APP_NAME', '');
define('APP_DESC', '');

/** 
 * true = Show error
 * false = hide error
 */
define('DEBUG', true);
