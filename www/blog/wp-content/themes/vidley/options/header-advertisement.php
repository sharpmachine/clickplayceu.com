<?php
	$option_fields[] = $header_ad = THEME_PREFIX . "header_ad";
?>

<div class="postbox">
    <h3>Optional 468x60 Header Advertisement</h3>
    
    <div class="inside">
    	<p>Use the field below to paste any 468x60 advertisement code:</p>
    	
    	<p><textarea class="option-area" id="<?php echo $header_ad; ?>" name="<?php echo $header_ad; ?>"><?php echo get_option($header_ad); ?></textarea></p>
    	
    	<p class="submit">
    		<input type="submit" class="button" value="Save Changes" />
    	</p>
    </div> <!-- inside -->
</div> <!-- postbox -->