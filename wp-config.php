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
define('DB_NAME', 'WordpressGallery');

/** MySQL database username */
define('DB_USER', 'WordpressGallery');

/** MySQL database password */
define('DB_PASSWORD', 'screebleflutage');

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
define('AUTH_KEY',         'M:!X#4R3kUa7>0d,+=%G2W[?jO~6`0CHyw 3yrF**!:5&ug%pNucGwkg%WLuQ$sC');
define('SECURE_AUTH_KEY',  'lsTJ>+2FwX!4H5QpvP<q H^qavXaK~[W/|gbz}|7y o8| G-Q]zN==GFL2eVQio ');
define('LOGGED_IN_KEY',    'lM0+p~S-pyr).|jv!+ug|.}.g5lsZ^Fg;5Ugo+z}Lv!3b@<2$J.cJ5{J[,T,s.)`');
define('NONCE_KEY',        'd+JKaS`0plLnCw_a<>YDZ%W-EnL-:F5mBwpr+a(o0+}=B$,.oCN@p7-B.T.|sQT8');
define('AUTH_SALT',        '+EpdYNen4L:$YK9hDl5sJUQy4!-h&-|`W|Z[TfdzdL0GNVMo<CBn0_f^34bkisS:');
define('SECURE_AUTH_SALT', '^E{C_!:oSr1S[kWpZ)5vW >EmHsYUp8/b4hAm+v+<+_M@oPck~-Yq.+*O}|3O@%%');
define('LOGGED_IN_SALT',   'hl|yn&Y.Z)>:oRrI-F*m|DupxnBS |NI]fxz=Pkp=]b6-JK1:ES^QY&z0{vt}9F-');
define('NONCE_SALT',       'U@ZowA+m1.-R{ aAXIcTz|H$[5Vc-2ab]FQmf },v9@iU&.!h, k}-DFRxLm2CP5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
