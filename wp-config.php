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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'plugin' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ntZcNsX`Qa2<o7bJ?%}dJ9: W>8n#B/Zt2rFnjGeSTk{QW*^p|[3C&@k;.+WIHks' );
define( 'SECURE_AUTH_KEY',  '4cx>EZ=8a=}n?/FH_X8(!v}8QF>j&)t594E}aA-;/3Hf/l1P%z7$(c1[a{O/U$mV' );
define( 'LOGGED_IN_KEY',    'ex2yGu{)7!S++1aRZBNppF%(roN6{5j3hC z5*/U3@Y+4}x$tR9C&6!&# /e(:7Z' );
define( 'NONCE_KEY',        '@Q5*Xt%{D&1q2~[o!HQC:,R0Rznm>3k$7hS@;?=3Z9YiR{ZKInopr49#gl&&<x]u' );
define( 'AUTH_SALT',        'BoF*7)i?1@D!B:+(fwD:_Z)Fboe@.*Ek7C|YDc#{$66?*$*2GWZ:un+w>WZH){VE' );
define( 'SECURE_AUTH_SALT', '_4f`B~wxTvb7DLUzRr|a)BSPAYha>[/nA9+#$nCSff`ekNgHlJ$n?Q~ *(U(Dc[O' );
define( 'LOGGED_IN_SALT',   'lcMwIg%OvB2ta7gu )o07MfCfBpf+]7:=QeFWBI/:%Q5@!uJE-b)a>d~wGid(cm|' );
define( 'NONCE_SALT',       ']T;E~->djKtNmpT;P$r;w0rwZZ3ons>Szd9,tV:L;~P`Cx/Ky|y&vlbaD1QSr{=g' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
