<?php get_header(); ?>
	
	<div id="video-container">
		<div id="video-container-inside">
			<div id="video-top">
				<!-- nothing to see here -->
			</div>
			
			<div id="video">
				<div id="coda-nav">
					<div class="coda-slider" id="slider">
						
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
						<div class="panel">
							<div class="panel-wrapper">
								<?php echo get_video($post->ID); ?>
								
								<div class="video-desc">
									<h2><?php the_title(); ?></h2>
									
									<?php the_content(); ?>
									
									<!-- <a class="continue-reading" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">Continue Reading</a> -->
									<a class="continue-reading" style="margin-right: 20px;" href="<?php bloginfo('url'); ?>/pricing-plans">Pricing Plans</a>
									<a class="continue-reading" href="<?php bloginfo('url'); ?>/#channels-inside">Start Learning</a>
								</div>
							</div>
						</div>
						
						<?php endwhile; else: ?>
						<?php endif; ?>
						<?php wp_reset_query(); ?>
					</div> <!-- coda-slider -->
				</div>
			</div> <!-- video -->
			
			<div id="video-bottom">
				<!-- nothing to see here -->
			</div>
			
		</div> <!-- video-container-inside -->
	</div> <!-- video-container -->
	
	<div id="easy-steps">


		<div id="container">
			<div id="content" role="main">

			<?php
			/* Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			 get_template_part( 'loop', 'index' );
			?>
			</div><!-- #content -->
		</div><!-- #container -->



	</div> <!-- channels -->
	
	
	
<?php get_footer(); ?>
