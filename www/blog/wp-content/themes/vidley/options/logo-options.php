<?php
	$option_fields[] = $logo_img = THEME_PREFIX . "logo_img";
	$option_fields[] = $logo_txt = THEME_PREFIX . "logo_txt";
	$option_fields[] = $tagline_text = THEME_PREFIX . "tagline_text";
?>

<div class="postbox">
    <h3>Logo Customization Options</h3>
    
    <div class="inside">
    	<p>Use the options below to upload and configure a custom image based logo or keep it simple and use a text based logo.</p>
    
    	<p><a href="media-upload.php?post_id=22&amp;type=image&amp;TB_iframe=true&width=640&height=517" id="add_image" class="thickbox onclick" title="Add an Image">Upload</a> a custom logo, then enter the path below:</p>
    	<p><input class="option-field" id="<?php echo $logo_img; ?>" type="text" name="<?php echo $logo_img; ?>" value="<?php echo get_option($logo_img); ?>" /></p>
    	
    	<p>Or simply use "text" for your logo instead:</p>
    	<p><input class="option-field-medium" id="<?php echo $logo_txt; ?>" type="text" name="<?php echo $logo_txt; ?>" value="<?php echo get_option($logo_txt); ?>" /></p>
    	
        <p>Enter your tagline text to be used on the Home Page:</p>
        <p><input class="option-field" id="<?php echo $tagline_text; ?>" type="text" name="<?php echo $tagline_text; ?>" value="<?php echo get_option($tagline_text); ?>" /></p>
        
        <p class="submit">
			<input type="submit" class="button" value="Save Changes" />
		</p>
    </div> <!-- inside -->
</div> <!-- postbox -->