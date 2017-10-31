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
define('DB_NAME', 'wordpress1');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '123@');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('FS_METHOD', 'direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'CT9)YF,WuI*S]c)?!kwgb)Wz9K?Fp3m.S^3p2a}>H!Fp[v<&8[`80rB2r|{JBjBB');
define('SECURE_AUTH_KEY',  'N0*Tq*,m/Kc?Fxgkwsw8R}N cgY0p&2 h=$),y;oa~7>1++uR(!x@4FXFSYY$M~A');
define('LOGGED_IN_KEY',    'Z1(xPZHGfo I/-we-JZ+No{E>2H]5=+0/pmtQ*5WJK>N-:-!NX)QyliE{I}p#./4');
define('NONCE_KEY',        ';oyHI#NS]w;QMtg)K875@LKl^.ujX~.G^n| x<*N!]HYSBy.G|M%WljF8jL dVry');
define('AUTH_SALT',        '!8PKa)C>Gj^u_}|a={6ONK*beiMTEBA,14#oNAD(%ZPG}WLXbkWz]$e)BU-I=23T');
define('SECURE_AUTH_SALT', 'RLZx `.CDbR]qUA]E?ul{m4vdzPi)zzR(q{QLi}O_yxBj*c(d*OF.8[rE_Rs%q+8');
define('LOGGED_IN_SALT',   'dMbv0*4#?~P,=[%U~A%t|Q7,%m6SdDVnl3|t6q)R_Xc%)VgAZcXCM*7~NH:ErUZ#');
define('NONCE_SALT',       '#44~*InyqvofGE}$dl}5>Zc9kfLC7m(:!+!pN6;o;RQ+f#Z;)d%{Umiz#d7tc@;(');

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
