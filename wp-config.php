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
error_reporting(0);
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'jarida');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '%HuU0qr;bv?%}quLFm|#jb:wT7}6W(84(=pk$gGfaD1+&6V|SzC.4[HDaqgLH%OY');
define('SECURE_AUTH_KEY',  '<Q4*DbkUq+rz!z[>OlNWbW.6N~;s}/R7Hj`Ggka1)m]s=OWeQN,jaf@bN!<@J;IV');
define('LOGGED_IN_KEY',    'j&1MVq2du:)2zTEse3@$-#mo .5h-2MWp|/SYX_HI~f7ql2|U8P?N-+]jkYmL|?3');
define('NONCE_KEY',        '-uQl.o.Ky0L{.S_NRE,=K;BiwBrO|uFHkg#{dQgs/$M*SuG8d=(lpGL))5%3F<Zy');
define('AUTH_SALT',        '~|FZ)>NY_q,|332_-sSi7suN)9J*fC$Hy(6COLSTF@*RlS|;(Ff]ZVgxW>}yP-*R');
define('SECURE_AUTH_SALT', 'v/VI&f+-WK%V,%kdps]Y/|JP1F@9lzKV8]jvl>DB/yZpM>-njE8}xN|;UsEmzRB[');
define('LOGGED_IN_SALT',   '7_#$&.>O@(_S:DK0`QZ-bH+=8q) WuX}w3r! dW+J]_%+]bX#o@CGsbO+#XC.p/>');
define('NONCE_SALT',       'A|H8+9i`&(vn|kj(N0n56uHJK;-J(Q76~Fht)M(*XOnQ1m.SE=uQf~8X#<FB%aT+');

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
