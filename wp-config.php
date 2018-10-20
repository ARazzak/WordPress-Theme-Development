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
define('DB_NAME', 'scholarship');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '!,hR$`cr,_pM6YU(]6BosI}u_apK9j/Dfu}m_KXV]gCO;JcSs1 =t0E(38=eoGh ');
define('SECURE_AUTH_KEY',  'fbnZf:@g4p)^kkK>.A&h*vi4v5d=F*+35^E< {([0>S^}0NI^UKw+<4manCbV7&3');
define('LOGGED_IN_KEY',    'P!zp-kT4@G8Y_PZ?X57!Rw,E}F$DclqcAp0hG?);<OwANv$5g-&uMk,y~Xoaq8sB');
define('NONCE_KEY',        'b~#IJdREthwu0ctF0MZ&uQ3nrw_LFXaTu%US^!.vk$?7?!/yxc GX,#)1_jXN;DZ');
define('AUTH_SALT',        '@A*WWe59cKie|}YyQVvX,(h]z+&,_ )y]^%V;v7U:nDoYjwfrlA`<?MUa9Oe9uv7');
define('SECURE_AUTH_SALT', '4)**uXa/Ub%NQLdx$;i*+/hc/]+jTnBdGe,^5yU`nj&~^lMKKc4xXJa[X+4H(UE-');
define('LOGGED_IN_SALT',   'l}4{lx,C5k!nep3Wnz5RZsjY|e8*UI6CV/6SSytj>pH0bu,Q%)=r:F9f7FAaVU~L');
define('NONCE_SALT',       '*(SSV`@T%E*PUcS=z/8kk:T@HHM-78cQ_<;MqqNtVP6,(j~(ezgfE;&%fqP%9Iw<');

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
