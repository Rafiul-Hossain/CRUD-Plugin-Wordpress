<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_crud' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'UXa=K6<:7W/?Mn+bBe8H$h*@s%.kFa@!lN|n47,IxWeh^s|cU5dyiDF&`k8fq(kF' );
define( 'SECURE_AUTH_KEY',  '>=`]E^]9f^qMK#/<kP>c$2<+%e2yH0xue$T= cKOE@u@^mUnZ3~CTbwyxH_`LP6y' );
define( 'LOGGED_IN_KEY',    'Jg?FK.6y9E7;f(xnB[~xU!2>qUYxkW80{PV[KwIq&?p`>fj#f@u0QMlf1Xo<Jjg8' );
define( 'NONCE_KEY',        '47ogQ}7=@?9[2XJo>!>.$NnoM#,=OFiEZ1zC()q5}g6XF2++>vB/XIeuo}wL!cMg' );
define( 'AUTH_SALT',        '=pAmVNuOHO;~ou(^FYow030UrInP(1#-YkEq0QWo/3ccqP$=`dAQ*RB8;F&XOG$Z' );
define( 'SECURE_AUTH_SALT', '?o3jJQJi;yD#~!vXlIAKQ-+LWLm-u|-i4:9ReU?JXTm|d}Az2t#bFG@:MB1gq#0L' );
define( 'LOGGED_IN_SALT',   'eX({:eTm?fXp!]o3U,_j,EJ}D@$%F{w FzPV@~KV G[A5QwY|(eb{d6zmeEIU(b3' );
define( 'NONCE_SALT',       'aJ0L!?-2T(:oMU2`uP-`@b`GuGW9sGg4| yN%+!Ne<J6;`|zo&(7]`+F_qfe1aBz' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );
// define( 'WP_DEBUG', false );
// define( 'WP_DEBUG_DISPLAY', true );
// define( 'WP_DEBUG_LOG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
