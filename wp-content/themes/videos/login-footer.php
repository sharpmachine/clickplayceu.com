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
				<p class="legal">&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?> - A division of Cosine Health Strategies, LLC.  <?php wp_nav_menu( array( 'container_class' => 'footer-menu', 'theme_location' => 'primary' , 'before' => '  | ' , 'menu_class' => 'footer-link-menu' ) ); ?>
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
