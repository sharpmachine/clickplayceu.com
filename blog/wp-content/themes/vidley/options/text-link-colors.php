<?php
	$option_fields[] = $content_bg = THEME_PREFIX . "content_bg";
	$option_fields[] = $content_text_color = THEME_PREFIX . "content_text_color";
	$option_fields[] = $content_link_color = THEME_PREFIX . "content_link_color";
	$option_fields[] = $content_link_hover_color = THEME_PREFIX . "content_link_hover_color";
	$option_fields[] = $heading_text_color = THEME_PREFIX . "heading_text_color";
	$option_fields[] = $heading_link_color = THEME_PREFIX . "heading_link_color";
	$option_fields[] = $heading_link_hover_color = THEME_PREFIX . "heading_link_hover_color";
?>

<div class="postbox">
    <h3>Custom Content and Text Colors</h3>
    
    <div class="inside">
    	<p>Use the options below to configure your site content, text &amp; link colors.</p>
		
		<div class="table">
			<div class="row">
				<div class="option">
			    	<label class="config_level">
						<label>Content Background Color</label>
					</label>
				</div>
				
				<div class="option-select">	
					<script language="javascript">
					(function($){
						var initLayout = function() {
							$('#<?php echo $content_bg; ?>').ColorPicker({
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
					
					#<input class="option-field-table" id="<?php echo $content_bg; ?>" type="text" name="<?php echo $content_bg; ?>" value="<?php echo get_option($content_bg); ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="option">
			    	<label class="config_level">
						<label>Content Text Color</label>
					</label>
				</div>
				
				<div class="option-select">	
					<script language="javascript">
					(function($){
						var initLayout = function() {
							$('#<?php echo $content_text_color; ?>').ColorPicker({
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
					
					#<input class="option-field-table" id="<?php echo $content_text_color; ?>" type="text" name="<?php echo $content_text_color; ?>" value="<?php echo get_option($content_text_color); ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="option">
			    	<label class="config_level">
						<label>Content Link Color</label>
					</label>
				</div>
				
				<div class="option-select">	
					<script language="javascript">
					(function($){
						var initLayout = function() {
							$('#<?php echo $content_link_color; ?>').ColorPicker({
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
					
					#<input class="option-field-table" id="<?php echo $content_link_color; ?>" type="text" name="<?php echo $content_link_color; ?>" value="<?php echo get_option($content_link_color); ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="option">
			    	<label class="config_level">
						<label>Content Link Hover Color</label>
					</label>
				</div>
				
				<div class="option-select">	
					<script language="javascript">
					(function($){
						var initLayout = function() {
							$('#<?php echo $content_link_hover_color; ?>').ColorPicker({
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
					
					#<input class="option-field-table" id="<?php echo $content_link_hover_color; ?>" type="text" name="<?php echo $content_link_hover_color; ?>" value="<?php echo get_option($content_link_hover_color); ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="option">
			    	<label class="config_level">
						<label>Heading Text Color</label>
					</label>
				</div>
				
				<div class="option-select">	
					<script language="javascript">
					(function($){
						var initLayout = function() {
							$('#<?php echo $heading_text_color; ?>').ColorPicker({
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
					
					#<input class="option-field-table" id="<?php echo $heading_text_color; ?>" type="text" name="<?php echo $heading_text_color; ?>" value="<?php echo get_option($heading_text_color); ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="option">
			    	<label class="config_level">
						<label>Heading Link Color</label>
					</label>
				</div>
				
				<div class="option-select">	
					<script language="javascript">
					(function($){
						var initLayout = function() {
							$('#<?php echo $heading_link_color; ?>').ColorPicker({
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
					
					#<input class="option-field-table" id="<?php echo $heading_link_color; ?>" type="text" name="<?php echo $heading_link_color; ?>" value="<?php echo get_option($heading_link_color); ?>" />
				</div>
			</div>
			
			<div class="row last">
				<div class="option">
			    	<label class="config_level">
						<label>Heading Link Hover Color</label>
					</label>
				</div>
				
				<div class="option-select">	
					<script language="javascript">
					(function($){
						var initLayout = function() {
							$('#<?php echo $heading_link_hover_color; ?>').ColorPicker({
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
					
					#<input class="option-field-table" id="<?php echo $heading_link_hover_color; ?>" type="text" name="<?php echo $heading_link_hover_color; ?>" value="<?php echo get_option($heading_link_hover_color); ?>" />
				</div>
			</div>
			    		
    		<div class="clearfix"></div>
    	</div>
    	
        <p class="submit">
			<input type="submit" class="button" value="Save Changes" />
		</p>
    </div> <!-- inside -->
</div> <!-- postbox -->