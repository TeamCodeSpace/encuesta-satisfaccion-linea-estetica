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
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/dh_apiamt/cmxdistribuidora.com.co/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'cmxdistribuidora_com_co_1');

/** MySQL database username */
define('DB_USER', 'kb7rp8qk');

/** MySQL database password */
define('DB_PASSWORD', '5TeQu3S!');

/** MySQL hostname */
define('DB_HOST', 'mysql.cmxdistribuidora.com.co');

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
define('AUTH_KEY',         'Ug_Swsoz;phXSa`162W@lfyR#Qpo#GYuPrahgqr2o0f;?M*:)fl8:+H!;6domy5R');
define('SECURE_AUTH_KEY',  'Bi%WC~)a(op$1j`q8*&leP`K1!3er1jvRl~1x^ngudEzhTI:p5Qrm0nQ7:/R~t(/');
define('LOGGED_IN_KEY',    'g:&#u^8kGn`i?7DBo+@180toCRm!!d/J"KB4o!gE_c?5g/M;0Q(Ezx7y8+)EXNkN');
define('NONCE_KEY',        '$y00(N(Qn7k51aJaP60v/Gyi!/Za#kZSp(ERlXIbfx3cfg~u0FbCpK@&/yBG|Ulq');
define('AUTH_SALT',        'XT(MWF1PY:6^CSC)?~5Od%Vr%"0DLGC(e&`fhMMj3tCmKbd&R|m4kFrcQFR2y#1I');
define('SECURE_AUTH_SALT', 'Z$9Omx^c26O|g5#qIO?^gI#huMW^h~amBNdG)2wWT7Ri1UW`X2S#mt_/?Rkr_u3p');
define('LOGGED_IN_SALT',   '|n`3Ur#n|6A8y3Ah8E41?)4#nqF_hdyc9G1^:xCP!K7eyN:4`|k!V)t$NNr&L_La');
define('NONCE_SALT',       '41api??18aO@~mP?"J/Wf$A"C%0xf3~((ycg&|9@;+RaUB?@l|q7NdvVgS*r%q9C');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_43gfxi_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'es_ES');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/**
 * Removing this could cause issues with your experience in the DreamHost panel
 */

if (isset($_SERVER['HTTP_HOST']) && preg_match("/^(.*)\.dream\.website$/", $_SERVER['HTTP_HOST'])) {
        $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        define('WP_SITEURL', $proto . '://' . $_SERVER['HTTP_HOST']);
        define('WP_HOME',    $proto . '://' . $_SERVER['HTTP_HOST']);
        define('JETPACK_STAGING_MODE', true);
}



/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
