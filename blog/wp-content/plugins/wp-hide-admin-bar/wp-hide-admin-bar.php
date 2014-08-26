<?php
/**
 * Plugin Name: WP Hide Admin Bar
 * Plugin URI: http://www.weboutsourcingteam.com/
 * Description: Plugin to hide admin toolbar from front end when login. For change settings (Settings -> WP Hide Admin Bar)
 * Author: Web Outsourcing Team
 * Version: 2.0
 * Author URI: http://www.weboutsourcingteam.com/
 * License: GPL2
 */




define( 'WP_HIDE_ADMIB_BAR_VERSION', '2.0' );
define( 'WHAB_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );
define( 'WHAB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WHAB_TRANSLATE_DOMAIN', 'whab' );

require_once( 'functions.load.php' );
require_once( 'class.admin.php' );

$WHAB_Admin = new WHAB_Admin();

add_action( 'admin_init', array( $WHAB_Admin, 'wp_hide_admin_bar_initialize' ) );
add_action( 'admin_menu', array( $WHAB_Admin, 'wp_hide_admin_bar_admin' ) );