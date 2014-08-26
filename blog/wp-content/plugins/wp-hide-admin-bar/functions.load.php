<?php
if (!defined('WP_HIDE_ADMIB_BAR_VERSION')) exit('No direct script access allowed');

function whab_register_settings() {
	register_setting( 'whab_display_admin_settings', 'whab_display_admin_settings' );
}

require_once(WHAB_PLUGIN_DIR.DIRECTORY_SEPARATOR.'admin.bar.php');

function whab_show_admin_bar($content){
    global $current_user;
    
    $adminSettingsPresent = get_option('whab_display_admin_settings','not_found');
    $show = null;
    if ($adminSettingsPresent != 'not_found' && $current_user->ID)
        foreach ($current_user->roles as $role_key) {
            if (empty($GLOBALS['wp_roles']->roles[$role_key]))
                continue;
            $role = $GLOBALS['wp_roles']->roles[$role_key];
            if (isset($adminSettingsPresent[$role['name']])) {
                if ($adminSettingsPresent[$role['name']] == 'show')
                    $show = true;
                    if ($adminSettingsPresent[$role['name']] == 'hide' && $show === null)
                        $show = false;
                    }
	}
    return $show === null ? $content : $show;
}

if ( is_admin() ){
    add_action('admin_init', 'whab_register_settings');
}else if ( !is_admin() ){
    add_filter( 'show_admin_bar' , 'whab_show_admin_bar');
}


