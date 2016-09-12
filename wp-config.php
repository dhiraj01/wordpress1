<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_demo');

/** MySQL database username */
define('DB_USER', 'dhiraj');

/** MySQL database password */
define('DB_PASSWORD', 'pass');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '}GqsBd%s@Q($w]?BK$0JxMt(s}N.<+o6WRp0s=qL&q&c/tzq3h=jy:CCF&m-eXei');
define('SECURE_AUTH_KEY',  'Zde>77WaA!R>@?)WA2c&u,!eRfh^7DBJ_1I{|MnJ+[je5#!uDKvHKg3&L]ux}~Jn');
define('LOGGED_IN_KEY',    '-~pJ)O=X.hC+Iy&sX)7o#-,h78,V-|7}Xvl:#,|bKL`TRCI1-y>mPOsL5nxaK5Mj');
define('NONCE_KEY',        'aR_kwg#gcazck4%%b%0d=w.!T6*bF;S8OTr1$&Yq{`Y>wCEkfcW}B?YuvIH4V+#e');
define('AUTH_SALT',        '4jTw{ah%[O-Us0%/&{#8,(C0{ ~tCaZt@$?M ,Jm=-bTQH#S&I@:2>c1(RK7N3Y#');
define('SECURE_AUTH_SALT', 'dY%q3;oZGvh%eynZS[;L*.!x$f6#`j:]Q-v.=PP2AJxL~c]m+Lai1i?.R%ny|3J&');
define('LOGGED_IN_SALT',   'UG%4[%]0`T>B;Dz{zsiQuBr[T5L~mh%e@ee~B1EEjHB2ekWaToo`%%J`<$dl@C^3');
define('NONCE_SALT',       '4?W${~(s`:]|-:@ANYb*aWal:w;%!?-#F8uzMN;]s=Qbf5r2^b(Nvq?Pj)[t(J$u');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
