	</div> <!-- post -->
							</div>
						</div> <!-- channels-inside -->
					</div> <!-- channels -->
				</div> <!-- main-page -->
			</div> <!-- content-inside -->
		</div> <!-- content -->
	<div id="footer">
		<div id="footer-inside">
			<?php if (get_option(THEME_PREFIX . "copy_text")) { ?>
				<p>&copy; <?php echo date("Y"); ?> <?php echo get_option(THEME_PREFIX . "copy_text"); ?> | <a href="<?php bloginfo('url'); ?>/privacy-policy">Privacy Policy</a> | <a href="<?php bloginfo('url'); ?>/terms-of-use">Terms of Use</a></p>
			<?php } ?>
			
			<?php if ( get_option(THEME_PREFIX . "footer_text") ) : ?>
				<p><?php echo get_option(THEME_PREFIX . "footer_text"); ?></p>
			<?php else : ?>
				
			<?php endif; ?>
			
			<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
		</div> <!-- footer-inside -->
	</div> <!-- footer -->
	
	<?php wp_footer(); ?>
</body>
</html>
