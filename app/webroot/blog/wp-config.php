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
define('DB_NAME', 'ibwtco_blog');

/** MySQL database username */
define('DB_USER', 'ibwtco_blog');

/** MySQL database password */
define('DB_PASSWORD', '6mLR{avWn.Bg');

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
define('AUTH_KEY',         'kLnX`?%~QhAH.Zd:Kd,4OJPlF5v@EG;D9jY08Ef==/!Q@UUZYQOw&@IXJSee-w]|');
define('SECURE_AUTH_KEY',  'y=)}:o<AC::l)|O]+@e]6_r|j0h.4jty;B(Md+}_d af|$[}HdjeOVKUK9AD2-`s');
define('LOGGED_IN_KEY',    'f/#pKyuVn8gJstJ =;-e]zE|J+_sJC/a9a%+{wv*P}MSio11r~yr%{tU_!*(N_61');
define('NONCE_KEY',        '^wD[E[7oasX$s/BAH4N=, |miCPAd|HT2d4bn%KykU_CX%5:iD|H%*Ka$on3]g$a');
define('AUTH_SALT',        '=o0Q A}K69my>wpOhCO2y5~^C2|@ZKn,A@@B2y4c,*+%5U~kmko+b_f[3~mYB,}c');
define('SECURE_AUTH_SALT', 'u0@1+u9-wk]$*bh8PGE2kXNVFZKP;,416ULhw`1G=LmUtg.bX%@&c7XWBE@Xp|?H');
define('LOGGED_IN_SALT',   'G:-^5|IND_?-Tmf0[f5Pf|}nf vd+W&+q0,Z6%`>J+}hZE={hQV0b9p}${HR$T t');
define('NONCE_SALT',       'S!l2rundm&3@#-s)d07?PN7;Z^0j&:qg7j^,ceN@&@DHBzQ)4>O2+ZBmmY(RAP>R');

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
