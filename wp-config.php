<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME','babyromandiech1');

/** MySQL database username */
define('DB_USER','bbr');

/** MySQL database password */
define('DB_PASSWORD','coco007');

/** MySQL hostname */
define('DB_HOST', 'mysql.babyromandie.ch');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY','E6WeuBC8n4euefYQ8z0gogOyfZUcUNloJXOxvB8lxtrueMjkOjjjjjMW5YOBamY8');
define('SECURE_AUTH_KEY','Ms7X+VVo7uH2+9i4ObY/DhABIUzPJ50rgbDE+CAe/YVWy/MkYZlSFu/eZ2JGESoL');
define('LOGGED_IN_KEY','HOCtnQLrjyGRgT5xBVzwTtVBnYLMloX9mxwnSk2Q5a4SabFd+ZG5l2+SS9wQ2Z/e');
define('NONCE_KEY','Ipmd6v9yxh6pkcT0h3y9VWJ86nGqItNIo0DlWw4THB5zPQwkl0PW7RMqE/EDGzMg');
define('AUTH_SALT','/qcSS5zIyeMoCaw92ERHaEr/wL5TjL6Oph3tsOneprRZqdgPAnf+ggIAQ5MfAFTA');
define('SECURE_AUTH_SALT','b+C4GiiJQQTPPinoXTJ8iqZFQPF0od3FsjoFi/iu/96mvAmjxbBbQMcKjPGjVZHs');
define('LOGGED_IN_SALT','bTkEbkNxAooY7VCcpiRB7GJCQcJsnqDYfmOa4TQVLkfMeR7wm5i0CTz6lBIa/hXa');
define('NONCE_SALT','DCIwzJrvGejXi5wY2GIcrJLW+TCUUdMBzp99wQWVVcK5NWErOuTdfsB4JCUEQYtP');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'fr_FR');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */
$pageURL = 'http';
if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
} else {
	$pageURL .= $_SERVER["SERVER_NAME"];
}
define('WP_SITEURL', $pageURL . '/wordpress');


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/wordpress/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
//require_once(ABSPATH . 'syno-misc.php');
