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
define( 'DB_NAME', 'flume_db' );

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

define( 'WP_MEMORY_LIMIT', '256M' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'eGxxkJl)}Ng2>-]5Tkdj>C]o4(q:gf{w*#G0Y]([n>qYAZk!<P9MUDzep<0/HukB' );
define( 'SECURE_AUTH_KEY',  '+!CK,8ur?Q`)-&c6^?F!J~s9e<un-:DJI.&dTO]]v@]DpV1-HUwP60f?_^7>q._/' );
define( 'LOGGED_IN_KEY',    ' +tc4,NYJe;YI?x*O99%H,!s=a)Bqa4;SNCD;X1&M3kg8my (*o2vL;3OnAbqCz~' );
define( 'NONCE_KEY',        '7?}?R(4jNOFu<ejieoK8olU$$@o033c$<JU$R}?S8~QUTdQvj?6M#Bk`LfX(b<x(' );
define( 'AUTH_SALT',        '1PIzpQ@gk]L~hA17%0Ew6SbP%xjER/IjhD SI|v|]bjP|RnLl@F;Sp:?a08Z!r(<' );
define( 'SECURE_AUTH_SALT', '8]Dq+^c9x.%/RajD&}/;{$t_Wecm8rf*(q.v]nO$o.JeV&&mR]:{%UwzDgEx^~EJ' );
define( 'LOGGED_IN_SALT',   '[iRWjfq$BH,dUu?(IA@QoC}(r(iixDqoYHy rMiM,uev,L2<Vo!p}JE2*h5-`mAN' );
define( 'NONCE_SALT',       'r_Ncs+1/DyR^~$z2()$X3^5;Ib(m)bzsK#.!{?oAXqR;@xubGZ%&,obS[&2ky}#j' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
