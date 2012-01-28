<?php
	$option_fields[] = $menu_management = THEME_PREFIX . "menu_management";
	$option_fields[] = $twitter_link = THEME_PREFIX . "twitter_link";
?>

<div class="postbox">
	<h3>Custom Menu Configuration Options</h3>
    
    <div class="inside">
    	<p>Enter your Twitter ID below to enable a twitter link within the main menu:</p>
    	<p>
    		<input class="option-field-side" id="<?php echo $twitter_link; ?>" type="text" name="<?php echo $twitter_link; ?>" value="<?php echo get_option($twitter_link); ?>" />
    	</p>
    	
    	<p>WordPress 3.0 includes custom menu management options. To enable this feature, simply check the box below and then click "Appearance" followed by "Menus" to create your own custom menus. Please note that when you enable Menu Management below that all the default theme menu items will be replaced.</p>
    
    	<p>
    		<label for="<?php echo $menu_management; ?>">
    	        <input class="checkbox" id="<?php echo $menu_management; ?>" type="checkbox" name="<?php echo $menu_management; ?>" value="true"<?php checked(TRUE, (bool) get_option($menu_management)); ?> /> <?php _e("Enable Menu Management"); ?>
    	    </label>
    	</p>
    	
    	<p class="submit">
    		<input type="submit" class="button" value="Save Changes" />
    	</p>
    </div> <!-- inside -->
</div> <!-- postbox -->
