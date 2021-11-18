<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'news' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'C]in2NFe>#4^X,G.J)F?+(:O@bD|r>X4Z-8.cnzfu7%<U(3#CJxkJR.L*bB0YGOX' );
define( 'SECURE_AUTH_KEY',  '|CV%N#y13FaRRf3<cL3hJ7u*Y&!4q<npz3-Gjq?FJY|+*($]!ECe|14;= _IR*xB' );
define( 'LOGGED_IN_KEY',    '|C3w7?/dhKSA>{t%Ov&$()K Z7U]@^}UQ&h=3~3Fi0/U.|_+(R)U#MH!~;_+x?n2' );
define( 'NONCE_KEY',        'Pae5VY &(?.iF(qokLBjjKQC(DQC =S|ua{aOlIs?$;./U@F$$>ZJvne%{rti2=g' );
define( 'AUTH_SALT',        'L{n8I:io.c]}}OR(>K++A/}LZIhMB~eS=,Z[LeG6F=D=9b;RC7#A1qsI]%k?HDr-' );
define( 'SECURE_AUTH_SALT', ' S;*/rUtB:8e^0L#!h#/.KK7Ot7OU#XV*.a=6Iy/2qy ;80d=kE]S-QCq0CQf[JR' );
define( 'LOGGED_IN_SALT',   'c,**0ABFL[4Fa}&PTCI$G0cLHH@Hn&ehtF$_{W4V,MIqh;M4F6]Z0Pe^OraV59`m' );
define( 'NONCE_SALT',       'Evb6cBpC]F10B6x>D7yKWNITxa-Du40d|=uHe9Nt(3RsIHn@g,S(<KL`A%13+eGl' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
