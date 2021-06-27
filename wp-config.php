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
define( 'DB_NAME', 'TESTERvanillastoreuio' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'tT5]lq)^T@tj/Lr:7X|Y5+MhOb*w-H801N50_*P68xyuSEx2xfZ^79.*( $NN6l;' );
define( 'SECURE_AUTH_KEY',  'AQV7bGf6kzXg@A-%<*yV&oW9]|zLlJCN/KYT1_G>E0Gde(|ANyvn|%g+nd,tZYB(' );
define( 'LOGGED_IN_KEY',    'C]=,}^XWNqF2O[&Cw^O?VhxdEq<DG7S>b`zndet}*Lq5K9d:N|1z:*_jXh^^D42V' );
define( 'NONCE_KEY',        'mmn57ei4ud`Me ^s6w^$ajSI9KxRC_I=%Vm_DCTk)N1e_=l0lJj>-{1L-RCOk=;[' );
define( 'AUTH_SALT',        '!pmA.JXl<=_(_S4T2NHN>,U.#17ZQcS/qT-Ra*=,at7$GEK#v##:jP%J(I|:4!*:' );
define( 'SECURE_AUTH_SALT', '3&cJg-dv!zlQV:dYPb/wliJW*ee66%q2L85Ce8;Y2djK>d+V~1K9we<o=jO`P^sl' );
define( 'LOGGED_IN_SALT',   'kIMxxEGfy$$Wn4OFY58v)+spo8rN@|g5l@86|=jytL.$2uqT-ah[Ttm2]nR=o-+!' );
define( 'NONCE_SALT',       '{`&dRyGNL021`}Yi$?i:Y0FhVa^g=C=0-:GsC_ehNevnB#77Y9 (&=<ym)H1(#[G' );

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
