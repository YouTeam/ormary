<?php
if (!defined('WP_HIDE_ADMIB_BAR_VERSION')) exit('No direct script access allowed');
function whab_display_admin_settings(){
?>		
	<form method="post">
	<?php 
		global $wp_roles;
	
		$whab_showAdminBar = get_option('whab_display_admin_settings');
               
		settings_fields('whab_display_admin_settings');
	?>
	<h2><?php _e('Show/Hide the Admin Bar on Front End', 'whab');?></h2>
	<table class="wp-list-table widefat fixed pages" cellspacing="0">
		<thead>
			<tr>
				<th id="manage-column" scope="col"><?php _e('User-group', 'whab');?></th>
				<th id="manage-column" scope="col"><?php _e('Visibility', 'whab');?></th>
			</tr>
		</thead>
			<tbody>
				<?php
				foreach ($wp_roles->roles as $role) {
					$key = $role['name'];
					$setting_exists = !empty($whab_showAdminBar[$key]);
					echo'<tr>
							<td id="manage-columnCell">'.$key.'</td>
							<td id="manage-columnCell">
								<input type="radio" name="whab_display_admin_settings['.$key.']" value="default" ';if (!$setting_exists || $whab_showAdminBar[$key] == 'default') echo ' checked'; echo'/>'; _e('Default', 'whab'); echo'<span style="padding-left:20px"></span>
	<input type="radio" name="whab_display_admin_settings['.$key.']" value="show"';if ($setting_exists && $whab_showAdminBar[$key] == 'show') echo ' checked';echo'/>'; _e('Show', 'whab'); echo'<span style="padding-left:20px"></span>
<input type="radio" name="whab_display_admin_settings['.$key.']" value="hide"';if ($setting_exists && $whab_showAdminBar[$key] == 'hide') echo ' checked';echo'/>'; _e('Hide', 'whab'); echo'
							</td>
						</tr>';
				}
				?>
			
	</table>

	<div align="right">
		<input type="hidden" name="action" value="update" />
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</div>
	</form>
<?php
}