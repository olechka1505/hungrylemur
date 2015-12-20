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
define('DB_NAME', 'hungryle_wpDiro2');

/** MySQL database username */
define('DB_USER', 'hungryle_wpDiro2');

/** MySQL database password */
define('DB_PASSWORD', ']5P!3pS9C2');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'kic799rhbfyiuurqwkppj2iptcksifrvna9xczx5pvhfwfwynjpkxd8twxp1nmd7');
define('SECURE_AUTH_KEY',  'a5augon9fcap7s4cqflvwqucbcrqapaws8euzpvptftfnluuizkeqvqhcxfyfrzc');
define('LOGGED_IN_KEY',    'vsencwqgyqvgxa5lg777zwjlsmt7unxzdflsgte39rwsvhjzeeczli5fot4ole4a');
define('NONCE_KEY',        'myaocxbb8zgz9q44t48wngmmux1jw02hkyzl0mgv7ccmwkelbyxdue1qgkysjcae');
define('AUTH_SALT',        'yenpkm7ddgjr0w4xen9oht8nww9m7ughkmszkfpbgduvr4spazi4nil98zvkun0w');
define('SECURE_AUTH_SALT', 'gnpcrwfjawaoxw0vdjglrtk8m0smmdvygm71whcxlmp5wwg9nrtkrtkt3bbwqtay');
define('LOGGED_IN_SALT',   'uvcn2brrctu3aer8y9oe4oajbe5clnbwiy3kyyspew7wtedg81dcbonvllhf1kzk');
define('NONCE_SALT',       'd0mtwl9ppreuipuz1ytyga5eurenhtxogrjpzggl1hrfn1tyeyyxvk5rbpee68h7');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'haj_';

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
define( 'WP_MEMORY_LIMIT', '128M' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
