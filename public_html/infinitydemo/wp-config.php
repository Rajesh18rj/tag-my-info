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
define( 'DB_NAME', 'websitew_wp973' );

/** Database username */
define( 'DB_USER', 'websitew_wp973' );

/** Database password */
define( 'DB_PASSWORD', '5]66STUpG.' );

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
define( 'AUTH_KEY',         'cgkqrggcbj2jllngixrzf5njconnnkub7trdb7oozk08f5jsefks8x8e7o3mrhun' );
define( 'SECURE_AUTH_KEY',  '5hwysj4pjovejchjuoabowr7acfvxxyzkasdemmsi497gcesmzqgvjad5wjbi3ak' );
define( 'LOGGED_IN_KEY',    'vstkff1hn4rfvjszsdndwwtobmhweuzdhe0xjqdcp3ezgyudhqk9e7qyfvvuweup' );
define( 'NONCE_KEY',        'k8co32a08oa9mplyozy6rruh11nbntvpulgujblh2lfwjt9k7agpyfwyayxqhs9q' );
define( 'AUTH_SALT',        '2kqlub2sad8bh8aujerfa8avnvqx0lvzjt6fhkxosyg1s6bs7hhmxsudjf9eveeh' );
define( 'SECURE_AUTH_SALT', 'bimplmwkyejfo7viv9l83dzrqfp0a4lo00zjbkzanzxsvnswmb4hqzfc1cpcgabr' );
define( 'LOGGED_IN_SALT',   'lycrzmddyesfdjjcavzcof9xzybldhzcugisbyper6bycmc4zfbpkar8cyecav12' );
define( 'NONCE_SALT',       'ardajyfnizldls9s081pvvg5tjr4fqmpvrfnix4tthzlxl99kltq0dbkwemu2nif' );

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
$table_prefix = 'wpck_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
