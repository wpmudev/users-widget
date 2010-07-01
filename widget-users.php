<?php
/*
Plugin Name: Users Widget
Description:
Author: Andrew Billits (Incsub)
Version: 1.0.0
Author URI:
*/

/* 
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//
$users_widget_main_blog_only = 'yes'; //Either 'yes' or 'no'
//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function widget_users_init() {
	global $wpdb, $users_widget_main_blog_only;
		
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// This saves options and prints the widget's config form.
	function widget_users_control() {
		global $wpdb;
		$options = $newoptions = get_option('widget_users');
		if ( $_POST['users-submit'] ) {
			$newoptions['users-title'] = $_POST['users-title'];
			$newoptions['users-display'] = $_POST['users-display'];
			$newoptions['users-display-name-characters'] = $_POST['users-display-name-characters'];
			$newoptions['users-order'] = $_POST['users-order'];
			$newoptions['users-number'] = $_POST['users-number'];
			$newoptions['users-avatar-size'] = $_POST['users-avatar-size'];
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_users', $options);
		}
	?>
				<div style="text-align:left">
                
				<label for="users-title" style="line-height:35px;display:block;"><?php _e('Title', 'widgets'); ?>:<br />
                <input class="widefat" id="users-title" name="users-title" value="<?php echo $options['users-title']; ?>" type="text" style="width:95%;">
                </select>
                </label>
				<label for="users-display" style="line-height:35px;display:block;"><?php _e('Display', 'widgets'); ?>:
                <select name="users-display" id="users-display" style="width:95%;">
                <option value="avatar_display_name" <?php if ($options['users-display'] == 'avatar_display_name'){ echo 'selected="selected"'; } ?> ><?php _e('Avatar + Display Name'); ?></option>
                <option value="avatar" <?php if ($options['users-display'] == 'avatar'){ echo 'selected="selected"'; } ?> ><?php _e('Avatar Only'); ?></option>
                <option value="display_name" <?php if ($options['users-display'] == 'display_name'){ echo 'selected="selected"'; } ?> ><?php _e('Display Name Only'); ?></option>
                </select>
                </label>
				<label for="users-display-name-characters" style="line-height:35px;display:block;"><?php _e('Display Name Characters', 'widgets'); ?>:<br />
                <select name="users-display-name-characters" id="users-display-name-characters" style="width:95%;">
                <?php
					if ( empty($options['users-display-name-characters']) ) {
						$options['users-display-name-characters'] = 30;
					}
					$counter = 0;
					for ( $counter = 1; $counter <= 500; $counter += 1) {
						?>
                        <option value="<?php echo $counter; ?>" <?php if ($options['users-display-name-characters'] == $counter){ echo 'selected="selected"'; } ?> ><?php echo $counter; ?></option>
                        <?php
					}
                ?>
                </select>
                </label>
				<label for="users-order" style="line-height:35px;display:block;"><?php _e('Order', 'widgets'); ?>:
                <select name="users-order" id="users-order" style="width:95%;">
                <option value="most_recent" <?php if ($options['users-order'] == 'most_recent'){ echo 'selected="selected"'; } ?> ><?php _e('Most Recent'); ?></option>
                <option value="random" <?php if ($options['users-order'] == 'random'){ echo 'selected="selected"'; } ?> ><?php _e('Random'); ?></option>
                </select>
                </label>
				<label for="users-number" style="line-height:35px;display:block;"><?php _e('Number', 'widgets'); ?>:<br />
                <select name="users-number" id="users-number" style="width:95%;">
                <?php
					if ( empty($options['users-number']) ) {
						$options['users-number'] = 10;
					}
					$counter = 0;
					for ( $counter = 1; $counter <= 25; $counter += 1) {
						?>
                        <option value="<?php echo $counter; ?>" <?php if ($options['users-number'] == $counter){ echo 'selected="selected"'; } ?> ><?php echo $counter; ?></option>
                        <?php
					}
                ?>
                </select>
                </label>
				<label for="users-avatar-size" style="line-height:35px;display:block;"><?php _e('Avatar Size', 'widgets'); ?>:<br />
                <select name="users-avatar-size" id="users-avatar-size" style="width:95%;">
                <option value="16" <?php if ($options['users-avatar-size'] == '16'){ echo 'selected="selected"'; } ?> ><?php _e('16px'); ?></option>
                <option value="32" <?php if ($options['users-avatar-size'] == '32'){ echo 'selected="selected"'; } ?> ><?php _e('32px'); ?></option>
                <option value="48" <?php if ($options['users-avatar-size'] == '48'){ echo 'selected="selected"'; } ?> ><?php _e('48px'); ?></option>
                <option value="96" <?php if ($options['users-avatar-size'] == '96'){ echo 'selected="selected"'; } ?> ><?php _e('96px'); ?></option>
                <option value="128" <?php if ($options['users-avatar-size'] == '128'){ echo 'selected="selected"'; } ?> ><?php _e('128px'); ?></option>
                </select>
                </label>
				<input type="hidden" name="users-submit" id="users-submit" value="1" />
				</div>
	<?php
	}
// This prints the widget
	function widget_users($args) {
		global $wpdb, $current_site;
		extract($args);
		$defaults = array('count' => 10, 'username' => 'wordpress');
		$options = (array) get_option('widget_users');

		foreach ( $defaults as $key => $value )
			if ( !isset($options[$key]) )
				$options[$key] = $defaults[$key];

		?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . __($options['users-title']) . $after_title; ?>
            <br />
            <?php

			$newoptions['users-display'] = $_POST['users-display'];
			$newoptions['users-order'] = $_POST['users-order'];
			$newoptions['users-number'] = $_POST['users-number'];
			$newoptions['users-avatar-size'] = $_POST['users-avatar-size'];
				//=================================================//
				if ( $options['users-order'] == 'most_recent' ) {
					$query = "SELECT ID, display_name FROM " . $wpdb->base_prefix . "users WHERE spam != '1' ORDER BY user_registered DESC LIMIT " . $options['users-number'];
				} else if ( $options['users-order'] == 'random' ) {
					$query = "SELECT ID, display_name FROM " . $wpdb->base_prefix . "users WHERE spam != '1' ORDER BY RAND() LIMIT " . $options['users-number'];
				}
				$users = $wpdb->get_results( $query, ARRAY_A );
				if (count(users) > 0){
					if ( $options['users-display'] == 'display_name' || $options['users-display'] == 'avatar_display_name' ) {
						echo '<ul>';
					}
					foreach ($users as $user){
						$primary_blog = get_active_blog_for_user( $user['ID'] );
						if ( $options['users-display'] == 'avatar_display_name' ) {
							echo '<li>';
							echo '<a href="' . $primary_blog->siteurl . '">' . get_avatar( $user['ID'], $options['users-avatar-size'], '' ) . '</a>';
							echo ' ';
							echo '<a href="' . $primary_blog->siteurl . '">' . substr($user['display_name'], 0, $options['users-display-name-characters']) . '</a>';
							echo '</li>';
						} else if ( $options['users-display'] == 'avatar' ) {
							echo '<a href="' . $primary_blog->siteurl . '">' . get_avatar( $user['ID'], $options['users-avatar-size'], '' ) . '</a>';
						} else if ( $options['users-display'] == 'display_name' ) {
							echo '<li>';
							echo '<a href="' . $primary_blog->siteurl . '">' . substr($user['display_name'], 0, $options['users-display-name-characters']) . '</a>';
							echo '</li>';
						}
					}
					if ( $options['users-display'] == 'display_name' || $options['users-display'] == 'avatar_display_name' ) {
						echo '</ul>';
					}
				}
				//=================================================//
			?>
		<?php echo $after_widget; ?>
<?php
	}
	// Tell Dynamic Sidebar about our new widget and its control
	if ( $users_widget_main_blog_only == 'yes' ) {
		if ( $wpdb->blogid == 1 ) {
			register_sidebar_widget(array(__('Users'), 'widgets'), 'widget_users');
			register_widget_control(array(__('Users'), 'widgets'), 'widget_users_control');
		}
	} else {
		register_sidebar_widget(array(__('Users'), 'widgets'), 'widget_users');
		register_widget_control(array(__('Users'), 'widgets'), 'widget_users_control');
	}
}

add_action('widgets_init', 'widget_users_init');

?>