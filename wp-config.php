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
define('DB_NAME', 'flower');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '12345');

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
define('AUTH_KEY',         'NKds5E=OSUbgg1&$eap|}3qnPuBRo~R%p-n6D>4iJJYkr:X|b+Jox^icp2.RHbkH');
define('SECURE_AUTH_KEY',  '].lk1(o}Vtk>S*v5wg65BY(,A2P ub5hVM2a0*[tdcTO-y-r}K+h|hXQ;bOB?[o4');
define('LOGGED_IN_KEY',    'i3{~U<xMv`Xf9Rg/ARyZL_#33aJIQ^ou,r|;F66i$+fjcDPEc>iF?6%fc^dK:/#L');
define('NONCE_KEY',        'voln-i3CcC|[$L[,2vZ!&3MTwi-sC)/|p-v_I?yD->-x| E?l,c*}G5PlpO }xN5');
define('AUTH_SALT',        '%%+cYzKGC7f,d|A~PZ4AFU-{~|e_TMRPb0],Hd%:F=-+zsaVU_! Yh30wG}8V}Z@');
define('SECURE_AUTH_SALT', 'i^CRizsEc}-sZW.9wf7~c0FAo#n+v-x]5(-u}^/Zz,:ZwtG:n.t$Qrf%lL~b|A.G');
define('LOGGED_IN_SALT',   'nQU~T %FRa-3Ij-VSTw){9B`)k5Jy rdot(BGu{E]?9JbhVgEtR<[7b^:i~67w12');
define('NONCE_SALT',       'W4e|W+J.G7YbvY`]VK6h)2AgBRD4$vuLW3z<S0ZY/>G>UT^`)$qQRjJIl_5~*6M`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
