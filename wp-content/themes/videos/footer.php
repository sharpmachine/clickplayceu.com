	<div id="footer">
		<div id="footer-inside">
			<?php if (get_option(THEME_PREFIX . "copy_text")) { ?>
				<p>&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?> - A division of Cosine Health Strategies, LLC.  |  <a href="<?php bloginfo('url'); ?>/how-it-works">How It Works</a> | <a href="<?php bloginfo('url'); ?>/state-requirements">State Requirements</a> | <a href="<?php bloginfo('url'); ?>/about">About</a> | <a href="<?php bloginfo('url'); ?>/faq">FAQ</a> | <a href="<?php bloginfo('url'); ?>/privacy-policy">Privacy Policy</a> | <a href="<?php bloginfo('url'); ?>/terms-of-use">Terms of Use</a> | <a href="<?php bloginfo('url'); ?>/contact-us">Contact Us</a></p>
			<?php } ?>
			
			<?php if ( get_option(THEME_PREFIX . "footer_text") ) : ?>
				<p><?php echo get_option(THEME_PREFIX . "footer_text"); ?></p>
			<?php else : ?>
				
			<?php endif; ?>
			
			<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
		</div> <!-- footer-inside -->
	</div> <!-- footer -->
	
	<?php wp_footer(); ?>
	
	<?php if (get_option(THEME_PREFIX . "no_ie")) { ?>
	<!--[if IE 6]>
	<script type="text/javascript"> 
		/*Load jQuery if not already loaded*/ if(typeof jQuery == 'undefined'){ document.write("<script type=\"text/javascript\"   src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js\"></"+"script>"); var __noconflict = true; } 
		var IE6UPDATE_OPTIONS = {
			icons_path: "http://static.ie6update.com/hosted/ie6update/images/"
		}
	</script>
	<script type="text/javascript" src="http://static.ie6update.com/hosted/ie6update/ie6update.js"></script>
	<![endif]-->
	<?php } ?>
	<script src="<?php bloginfo('template_directory'); ?>/scripts/jquery.qtip-1.0.0.min.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_directory'); ?>/scripts/jquery.scrollTo-1.4.2-min.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>

