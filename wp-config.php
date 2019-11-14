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
define( 'DB_NAME', 'zeminrme_zeminDatabase' );

/** MySQL database username */
define( 'DB_USER', 'zeminrme_zemin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Huangjue517' );

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
define( 'AUTH_KEY',         '-$:HCn02%3aXJKeZLylZUIPc~r#@Wf3Ny7N<IyZS!D$:i8sZ7E4Xg6|7VZx&cG!6' );
define( 'SECURE_AUTH_KEY',  'J&_.q,v)hkXPM|xZ&bDVA4VCACKjNldzEPX!SH0Y|Qo9QVf/cc+?BVL&W~?;#4gt' );
define( 'LOGGED_IN_KEY',    'lHsJbJ/ C/er6oF`<9-&++He,u2g}3oi~+l/k.;UL*qAx,64#;QlcUw37{F(YM=c' );
define( 'NONCE_KEY',        'Ez)$qg@/HY3TmO!B`G:=biPc-2@vT^D&2M?tvpt)h`giViD1==7b!NVj<S~N>:}c' );
define( 'AUTH_SALT',        'Rk1xdcY{H}]3|K3}.qh(~s1t=wvd]! ECy_4u- i&{>#:HQiF#@[3c:[b?_mPL./' );
define( 'SECURE_AUTH_SALT', 'wrW?HW4O&,vuA/Wn-WJZKpx[cPB+2pzh=r6rl@*z+Z>XQ!v<Nu2xtwPa4Or0PrP?' );
define( 'LOGGED_IN_SALT',   'w1pzMCLQv^kAY}!pV/zhiX.XK{l{Dr+zp oDM)Ss:9<p@d P?J]$?ADD)9lBdTSj' );
define( 'NONCE_SALT',       'q5_[8192KyiV^CsJh5vBrL1<@Qf3@EtezAg!5#@RT6b[2*|QL+K4%A/_F1U)T*([' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'info_';

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
