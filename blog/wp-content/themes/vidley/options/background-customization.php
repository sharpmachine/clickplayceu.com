<?php
	$option_fields[] = $background_img = THEME_PREFIX . "background_img";
	$option_fields[] = $background_fixed = THEME_PREFIX . "background_fixed";
	$option_fields[] = $background_color = THEME_PREFIX . "background_color";
	$option_fields[] = $background_vert = THEME_PREFIX . "background_vert";
	$option_fields[] = $background_horiz = THEME_PREFIX . "background_horiz";
	$option_fields[] = $background_repeat = THEME_PREFIX . "background_repeat";
?>

<div class="postbox">
    <h3>Theme Background Image and Background Color Configuration</h3>
    
    <div class="inside">
    	<p>Use the options below to configure your site background image/color styles as well as border element colors. Please note that all the fields below must be configured for this feature to function properly.</p>
    				    	
		<p><a href="media-upload.php?post_id=22&amp;type=image&amp;TB_iframe=true&width=640&height=517" id="add_image" class="thickbox onclick" title="Add an Image">Upload</a> a custom background image, then enter "Link URL" below:</p>
		<p><input class="option-field" id="<?php echo $background_img; ?>" type="text" name="<?php echo $background_img; ?>" value="<?php echo get_option($background_img); ?>" /></p>
		
		<p>
			<label for="<?php echo $background_fixed; ?>">
		        <input id="<?php echo $background_fixed; ?>" type="checkbox" name="<?php echo $background_fixed; ?>" value="true"<?php checked(TRUE, (bool) get_option($background_fixed)); ?> /> Fixed Background Position
		    </label>
		</p>
		
		<div class="table">
			<div class="row">
            	<div class="option">
                	<label class="config_level">
						<label>Background Color</label>
					</label>
				</div>
				
				<div class="option-select">	
					<script language="javascript">
					(function($){
						var initLayout = function() {
							$('#<?php echo $background_color; ?>').ColorPicker({
								onSubmit: function(hsb, hex, rgb, el) {
									$(el).val(hex);
									$(el).ColorPickerHide();
								},
								onBeforeShow: function () {
									$(this).ColorPickerSetColor(this.value);
								}
							})
							.bind('keyup', function(){
								$(this).ColorPickerSetColor(this.value);
							});
						};
						
						EYE.register(initLayout, 'init');
					})(jQuery)
					</script>
					
					#<input class="option-field-table" id="<?php echo $background_color; ?>" type="text" name="<?php echo $background_color; ?>" value="<?php echo get_option($background_color); ?>" />
				</div>
    		</div>
    		
    		<div class="row">
            	<div class="option">
                	<label class="config_level">
						<label>Vertical Alignment</label>
					</label>
				</div>

				<div class="option-select">	
					<?php $bgv = get_option(THEME_PREFIX . "background_vert"); ?>
				
					<select id="<?php echo $background_vert; ?>" name="<?php echo $background_vert; ?>">						
						<option value="top"<?php if ($bgv=="top") echo 'selected="selected"' ?>>Top</option>
						<option value="center"<?php if ($bgv=="center") echo 'selected="selected"' ?>>Center</option>
						<option value="bottom"<?php if ($bgv=="bottom") echo 'selected="selected"' ?>>Bottom</option>
					</select>
				</div>
    		</div>
    		
    		<div class="row">
            	<div class="option">
                	<label class="config_level">
						<label>Horizontal Alignment</label>
					</label>
				</div>

				<div class="option-select">	
					<?php $bgh = get_option(THEME_PREFIX . "background_horiz"); ?>
				
					<select id="<?php echo $background_horiz; ?>" name="<?php echo $background_horiz; ?>">						
						<option value="left"<?php if ($bgh=="left") echo 'selected="selected"' ?>>Left</option>
						<option value="center"<?php if ($bgh=="center") echo 'selected="selected"' ?>>Center</option>
						<option value="right"<?php if ($bgh=="right") echo 'selected="selected"' ?>>Right</option>
					</select>
				</div>
    		</div>
    		
    		<div class="row last">
            	<div class="option">
                	<label class="config_level">
						<label>Background Repeat</label>
					</label>
				</div>
				
				<div class="option-select">	
					<?php $bgr = get_option(THEME_PREFIX . "background_repeat"); ?>
				
					<select id="<?php echo $background_repeat; ?>" name="<?php echo $background_repeat; ?>">
						<option value="no-repeat"<?php if ($bgr=="no-repeat") echo 'selected="selected"' ?>>No Repeat</option>
						<option value="repeat-x"<?php if ($bgr=="repeat-x") echo 'selected="selected"' ?>>Repeat Horizontally</option>
						<option value="repeat-y"<?php if ($bgr=="repeat-y") echo 'selected="selected"' ?>>Repeat Vertically</option>
						<option value="repeat"<?php if ($bgr=="repeat") echo 'selected="selected"' ?>>Repeat Both</option>
					</select>
				</div>
    		</div>
    		
    		<div class="clearfix"></div>
    	</div>
    	
        <p class="submit">
			<input type="submit" class="button" value="Save Changes" />
		</p>
    </div> <!-- inside -->
</div> <!-- postbox -->