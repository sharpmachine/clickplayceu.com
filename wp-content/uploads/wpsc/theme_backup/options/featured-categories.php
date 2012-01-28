<?php
	$option_fields[] = $enable_category_1 = THEME_PREFIX . "enable_category_1";
	$option_fields[] = $enable_category_2 = THEME_PREFIX . "enable_category_2";
	$option_fields[] = $enable_category_3 = THEME_PREFIX . "enable_category_3";
	$option_fields[] = $enable_category_4 = THEME_PREFIX . "enable_category_4";
	$option_fields[] = $enable_category_5 = THEME_PREFIX . "enable_category_5";
	$option_fields[] = $enable_category_6 = THEME_PREFIX . "enable_category_6";
	$option_fields[] = $enable_category_7 = THEME_PREFIX . "enable_category_7";
	$option_fields[] = $enable_category_8 = THEME_PREFIX . "enable_category_8";
	$option_fields[] = $enable_category_9 = THEME_PREFIX . "enable_category_9";
	$option_fields[] = $enable_category_10 = THEME_PREFIX . "enable_category_10";
	$option_fields[] = $enable_category_11 = THEME_PREFIX . "enable_category_11";
	$option_fields[] = $enable_category_12 = THEME_PREFIX . "enable_category_12";
	$option_fields[] = $featured_category_1 = THEME_PREFIX . "featured_category_1";
	$option_fields[] = $featured_category_2 = THEME_PREFIX . "featured_category_2";
	$option_fields[] = $featured_category_3 = THEME_PREFIX . "featured_category_3";
	$option_fields[] = $featured_category_4 = THEME_PREFIX . "featured_category_4";
	$option_fields[] = $featured_category_5 = THEME_PREFIX . "featured_category_5";
	$option_fields[] = $featured_category_6 = THEME_PREFIX . "featured_category_6";
	$option_fields[] = $featured_category_7 = THEME_PREFIX . "featured_category_7";
	$option_fields[] = $featured_category_8 = THEME_PREFIX . "featured_category_8";
	$option_fields[] = $featured_category_9 = THEME_PREFIX . "featured_category_9";
	$option_fields[] = $featured_category_10 = THEME_PREFIX . "featured_category_10";
	$option_fields[] = $featured_category_11 = THEME_PREFIX . "featured_category_11";
	$option_fields[] = $featured_category_12 = THEME_PREFIX . "featured_category_12";
?>

<div class="postbox">
    <h3>Featured Categories (Home Page)</h3>
    
    <div class="inside">
    	<p>Select up to 12 featured categories to display on the home page. These categories will be displayed right below the featured content carousel and are represented by the latest post thumbnail added to each post within each featured category.</p>
				
		<div class="table">
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_1; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_1; ?>" type="checkbox" name="<?php echo $enable_category_1; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_1)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_1, 'id' => $featured_category_1,'selected' => get_option($featured_category_1) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_2; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_2; ?>" type="checkbox" name="<?php echo $enable_category_2; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_2)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_2, 'id' => $featured_category_2,'selected' => get_option($featured_category_2) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_3; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_3; ?>" type="checkbox" name="<?php echo $enable_category_3; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_3)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_3, 'id' => $featured_category_3,'selected' => get_option($featured_category_3) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_4; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_4; ?>" type="checkbox" name="<?php echo $enable_category_4; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_4)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_4, 'id' => $featured_category_4,'selected' => get_option($featured_category_4) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_5; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_5; ?>" type="checkbox" name="<?php echo $enable_category_5; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_5)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_5, 'id' => $featured_category_5,'selected' => get_option($featured_category_5) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_6; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_6; ?>" type="checkbox" name="<?php echo $enable_category_6; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_6)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_6, 'id' => $featured_category_6,'selected' => get_option($featured_category_6) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_7; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_7; ?>" type="checkbox" name="<?php echo $enable_category_7; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_7)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_7, 'id' => $featured_category_7,'selected' => get_option($featured_category_7) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_8; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_8; ?>" type="checkbox" name="<?php echo $enable_category_8; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_8)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_8, 'id' => $featured_category_8,'selected' => get_option($featured_category_8) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_9; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_9; ?>" type="checkbox" name="<?php echo $enable_category_9; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_9)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_9, 'id' => $featured_category_9,'selected' => get_option($featured_category_9) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_10; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_10; ?>" type="checkbox" name="<?php echo $enable_category_10; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_10)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_10, 'id' => $featured_category_10,'selected' => get_option($featured_category_10) ) ); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="option">
					<label for="<?php echo $enable_category_11; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_11; ?>" type="checkbox" name="<?php echo $enable_category_11; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_11)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_11, 'id' => $featured_category_11,'selected' => get_option($featured_category_11) ) ); ?>
				</div>
			</div>
			
			<div class="row last">
				<div class="option">
					<label for="<?php echo $enable_category_12; ?>">
					    <input class="checkbox" id="<?php echo $enable_category_12; ?>" type="checkbox" name="<?php echo $enable_category_12; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_category_12)); ?> /> <?php _e("Enable"); ?>
					</label>
				</div>
				
				<div class="option-select">	
					<?php wp_dropdown_categories( array( 'name' => $featured_category_12, 'id' => $featured_category_12,'selected' => get_option($featured_category_12) ) ); ?>
				</div>
			</div>
		</div>	
		
		<p class="submit">
			<input type="submit" class="button" value="Save Changes" />
		</p>
    </div> <!-- inside -->
</div> <!-- postbox -->
