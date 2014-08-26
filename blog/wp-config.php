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
define('DB_NAME', 'ormary_wpblog');

/** MySQL database username */
define('DB_USER', 'ormary_wp');

/** MySQL database password */
define('DB_PASSWORD', 'uE]EcR"7x\Dk7kz');

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
define('AUTH_KEY', '|QyPIqghnxEPCGJDY*HxnBp}ggUBYp-gaXZ)zXEv<Gs>+?opFA;-Ub*$FNM=aW-*s_[v)RzcE>KOLKCot]DMn<lWYXG^+(W|L(oO*[FoBIMKCuo<y=l?n=U_m)^SeY]$');
define('SECURE_AUTH_KEY', '%r&/v/eKmRE-FjUmBpxgcRRN-oFMpUKzl/HzFyWersnkv^xk[?tg=KGXkc>gUiqUssk_?TGG++}fuu{FdukyIf+cfpZmWB^F[XM>K@bX)Wd%H=IM)Zr<HuxZMIefU%+p');
define('LOGGED_IN_KEY', '?BXlAH&C(eT!|OGckH&z}N^]c!_}@RhpSOBJU_!{!RJnC;mH^)*L|NpdZYv/TxxaP]*>Hxsw&||yQ@UvZvriNdZA|EA^CZ>j}m{kjyk@AxQy^sA[!;w=GzdYbcbouRMO');
define('NONCE_KEY', '@NY}qh<h;fjipiOd*is[mtccVFlyp)O+{w@+/lT](<Iae|[k>-OnICcOewTMALm/Jy=T/bgHMthhgZ+cBtW{WmSck<]@-wRzL*os+vhiWzF[tdmRl(w|J!L-uEEqXG&C');
define('AUTH_SALT', '@abE_IMSRI{$HaMkTwpDGn+PxP*i-;;TixhFxg&v;JiFCv!B|PtQD]pXH{A>sW!>R-c^<L(Bre@CevOtBRcyk_JCCGsCBWiL%LscDXQpIQhhQH/BZ=gAvLzrjTa+kiwu');
define('SECURE_AUTH_SALT', 'MdWxvq<psy$+I?U}LG*Yirkb*enXZmE&SW{eX[%tKRqT(Y(Zl!CvMsFuIA$GmLd&+{fd+v+=?uZWr|IX(r|nP&=RB<%Y!IDgEU<Y<xpc(WR_*-])mOuA[;LhC?/{tWG=');
define('LOGGED_IN_SALT', 'vX[DEluutYAO_*_(kd>|nsdN}rzhD%kz))k_uUE<B?cHKvlyQ>NQXu<<]S]$yPu?sfWQn}=E]HRp+=(HLny(&wa{eLvVPwiog=%w*nAv)Qs%_w&(]kJ>zlj&F>gNkjUp');
define('NONCE_SALT', 'vJtvZ$cYf|gmzc%*TqeO/n+|w(/GPjz>>oy=b_q*-uJ(lryl@Z+B^BS%_ILBwFAVS/(H>^b%?cWBYZa-b_A[!fP&j*(KCHW)bl(b>[d+QgV_+Adk*xMNwv(K![S(dGvG');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_fmis_';

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
