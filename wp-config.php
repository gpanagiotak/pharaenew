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
define( 'DB_NAME', 'pharae_new' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:8889' );

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
define( 'AUTH_KEY',         'SjELUO7B+u1Vb:1y%RL[QLOX{=AVg^c)|QtQtM,7]?rb`47-2=9s%Ky6/4R(N[U%' );
define( 'SECURE_AUTH_KEY',  ':pa(yN-twOl0ST/|F%rZur;M3n-&4$FnwBl)&o#CBu>]9CY(P7adMDj-xx%(%m,X' );
define( 'LOGGED_IN_KEY',    'mYw;SeO_,<;>3,%x@ h(/PwE>WwJzg6?j7ximkL&WVLp3 PiZ/zp=_c5hX#H3?K:' );
define( 'NONCE_KEY',        'Z>eKtDVvvcvX0#10z*W7}HocY1TrZ]&] g;fW+IL/0_B}tHg22>_Oi>(eIv_&R#)' );
define( 'AUTH_SALT',        'v;0B$_FV,=@.la=YqmFR+zTYzBMSZ61/`O2 Y1=qgM_9Xd*lx6xOF&<cd[SO3{Qt' );
define( 'SECURE_AUTH_SALT', '7HX6Zth+$> V7%A3*,|ZN vYoQ1},;zE1$oXlI=P@$Civ%=P+i<0zFP<Yv87`d#s' );
define( 'LOGGED_IN_SALT',   'YnD+f[d -m*_-G!;_aS6xfR$@JIBF9d{3sH~OCbl~TV^A$1`eEu)e+i1WM8%!MRI' );
define( 'NONCE_SALT',       'EPfRd-BVy]U^wQ2KcI[y9-|(YjQ(KXy7sz&VL=WF**_0%0hd}6yN(y.YI]A1wGBG' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'phrne_';

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
