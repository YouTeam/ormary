<?php
if (!defined('WP_HIDE_ADMIB_BAR_VERSION')) exit('No direct script access allowed');
class WHAB_Admin{
    
    function __construct(){
		$this->version = WP_HIDE_ADMIB_BAR_VERSION;
	}
        
        function wp_hide_admin_bar_initialize(){
		// check for activation
		$this->wp_hide_admin_bar_activate();
		
		return false;
	}
        
        function wp_hide_admin_bar_activate(){
            global $wp_roles;
            $all_roles = $wp_roles->roles;
            $editable_roles = apply_filters('editable_roles', $all_roles);
            $admintSettingsPresent = get_option('whab_display_admin_settings','not_found');
            if ($admintSettingsPresent == 'not_found'){          // if the field doesn't exists, then create it
                $rolesArray = array();
                    foreach ( $editable_roles as $key => $data )
                        $rolesArray = array( $data['name'] => 'hide' ) + $rolesArray;
			$rolesArray = array_reverse($rolesArray,true);
                       
                    update_option( 'whab_display_admin_settings', $rolesArray);
		}
        }
        
        function wp_hide_admin_bar_admin(){
		// create menu item
		$wp_hide_admin_bar_options = add_submenu_page( 'options-general.php', 'WP Hide Admin Bar', 'WP Hide Admin Bar', 'delete_users', 'WPHideAdminBar', array( $this, 'whab_options_page' ) );
	}
    function whab_options_page() {
        $this->update_whab_option(); ?>
<div id="framework_wrap" class="wrap">
  <div id="content_wrap">
      <div id="content">
      
        <div id="options_tabs">

			<div id="show-hide-admin-bar" class="block has-table">
			<?php whab_display_admin_settings(); ?>
			</div>
	
	
			<br class="clear" />
   
        </div>
        
      </div>
     
      <div class="info bottom"></div> 

  </div>
</div>
 <?php   }
 
 function update_whab_option(){
    
     if(isset($_POST['action']) && $_POST['action']=='update'){
        $rolesArray =$_POST['whab_display_admin_settings'];
        update_option( 'whab_display_admin_settings', $rolesArray);
     }
 }
}