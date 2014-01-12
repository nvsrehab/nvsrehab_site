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
 *
 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

 /** For security, WordPress Local Environment DB credentials including
 * the database name, password and host for wordpress and the authentication
 * unique keys and salts, are stored in the file: /public/wordpress_437746477/production-config.php
 */

define( 'DB_CREDENTIALS_PATH', ABSPATH ); // cache it for multiple use
define( 'WP_LOCAL_SERVER', file_exists( DB_CREDENTIALS_PATH . '/local-config.php' ) );

if ( WP_LOCAL_SERVER )
    require DB_CREDENTIALS_PATH . '/local-config.php';
else
    require DB_CREDENTIALS_PATH . '/production-config.php';

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
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

if ( WP_LOCAL_SERVER )
   var_dump(__FILE__);
   define('WP_DEBUG', true);


/* That's all, stop editing! Happy blogging. */


/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('FS_METHOD','direct');
