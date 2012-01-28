<?php get_header(); ?>
	<div id="content">
		<div id="content-inside">
			<div id="breadcrumbs">
				<p><?php echo get_option(THEME_PREFIX . "tagline_text"); ?></p>
				<?php include('searchform.php'); ?>
			</div> <!-- breadcrumbs -->
		
			<div class="divider-bottom">
				<!-- nothing to see here -->
			</div>
		</div>
	</div>
	
	<div id="video-container">
		<div id="video-container-inside">
			<div id="video-top">
				<!-- nothing to see here -->
			</div>
			
			<div id="video">
				<div id="coda-nav">
					<div class="coda-slider" id="slider">
						<?php
							$cat = get_option(THEME_PREFIX . "featured_content");
							$num = get_option(THEME_PREFIX . "featured_num");
							query_posts("cat=$cat&showposts=$num");
						?>    
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
						<div class="panel">
							<div class="panel-wrapper">
								<?php echo get_video($post->ID); ?>
								
								<div class="video-desc">
									<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									
									<?php the_excerpt(); ?>
									
									<a class="continue-reading" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">Continue Reading</a>
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
	
	<div id="channels">
		<div id="channels-inside">
			<div id="channels-wrapper">
			<!-- featured category #1 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_1") ) : ?>
				<?php
				    $category_id_1 = get_option(THEME_PREFIX . "featured_category_1");
				    $category_link_1 = get_category_link( $category_id_1 );
				?>
				
				<?php query_posts("cat=$category_id_1&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_1; ?>" title="View all the video in: <?php echo get_cat_name($category_id_1); ?>"></a>
					<h4><?php echo get_cat_name($category_id_1); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #2 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_2") ) : ?>
				<?php
				    $category_id_2 = get_option(THEME_PREFIX . "featured_category_2");
				    $category_link_2 = get_category_link( $category_id_2 );
				?>
				
				<?php query_posts("cat=$category_id_2&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_2; ?>" title="View all the video in: <?php echo get_cat_name($category_id_2); ?>"></a>
					<h4><?php echo get_cat_name($category_id_2); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #3 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_3") ) : ?>
				<?php
				    $category_id_3 = get_option(THEME_PREFIX . "featured_category_3");
				    $category_link_3 = get_category_link( $category_id_3 );
				?>
				
				<?php query_posts("cat=$category_id_3&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_3; ?>" title="View all the video in: <?php echo get_cat_name($category_id_3); ?>"></a>
					<h4><?php echo get_cat_name($category_id_3); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #4 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_4") ) : ?>
				<?php
				    $category_id_4 = get_option(THEME_PREFIX . "featured_category_4");
				    $category_link_4 = get_category_link( $category_id_4 );
				?>
				
				<?php query_posts("cat=$category_id_4&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_4; ?>" title="View all the video in: <?php echo get_cat_name($category_id_4); ?>"></a>
					<h4><?php echo get_cat_name($category_id_4); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #5 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_5") ) : ?>
				<?php
				    $category_id_5 = get_option(THEME_PREFIX . "featured_category_5");
				    $category_link_5 = get_category_link( $category_id_5 );
				?>
				
				<?php query_posts("cat=$category_id_5&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_5; ?>" title="View all the video in: <?php echo get_cat_name($category_id_5); ?>"></a>
					<h4><?php echo get_cat_name($category_id_5); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #6 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_6") ) : ?>
				<?php
				    $category_id_6 = get_option(THEME_PREFIX . "featured_category_6");
				    $category_link_6 = get_category_link( $category_id_6 );
				?>
				
				<?php query_posts("cat=$category_id_6&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_6; ?>" title="View all the video in: <?php echo get_cat_name($category_id_6); ?>"></a>
					<h4><?php echo get_cat_name($category_id_6); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #7 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_7") ) : ?>
				<?php
				    $category_id_7 = get_option(THEME_PREFIX . "featured_category_7");
				    $category_link_7 = get_category_link( $category_id_7 );
				?>
				
				<?php query_posts("cat=$category_id_7&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_7; ?>" title="View all the video in: <?php echo get_cat_name($category_id_7); ?>"></a>
					<h4><?php echo get_cat_name($category_id_7); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #8 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_8") ) : ?>
				<?php
				    $category_id_8 = get_option(THEME_PREFIX . "featured_category_8");
				    $category_link_8 = get_category_link( $category_id_8 );
				?>
				
				<?php query_posts("cat=$category_id_8&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_8; ?>" title="View all the video in: <?php echo get_cat_name($category_id_8); ?>"></a>
					<h4><?php echo get_cat_name($category_id_8); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #9 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_9") ) : ?>
				<?php
				    $category_id_9 = get_option(THEME_PREFIX . "featured_category_9");
				    $category_link_9 = get_category_link( $category_id_9 );
				?>
				
				<?php query_posts("cat=$category_id_9&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_9; ?>" title="View all the video in: <?php echo get_cat_name($category_id_9); ?>"></a>
					<h4><?php echo get_cat_name($category_id_9); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #10 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_10") ) : ?>
				<?php
				    $category_id_10 = get_option(THEME_PREFIX . "featured_category_10");
				    $category_link_10 = get_category_link( $category_id_10 );
				?>
				
				<?php query_posts("cat=$category_id_10&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_10; ?>" title="View all the video in: <?php echo get_cat_name($category_id_10); ?>"></a>
					<h4><?php echo get_cat_name($category_id_10); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			<!-- featured category #11 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_11") ) : ?>
				<?php
				    $category_id_11 = get_option(THEME_PREFIX . "featured_category_11");
				    $category_link_11 = get_category_link( $category_id_11 );
				?>
				
				<?php query_posts("cat=$category_id_11&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_11; ?>" title="View all the video in: <?php echo get_cat_name($category_id_11); ?>"></a>
					<h4><?php echo get_cat_name($category_id_11); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>
			
			<!-- featured category #12 -->
			<?php if ( get_option(THEME_PREFIX . "enable_category_12") ) : ?>
				<?php
				    $category_id_12 = get_option(THEME_PREFIX . "featured_category_12");
				    $category_link_12 = get_category_link( $category_id_12 );
				?>
				
				<?php query_posts("cat=$category_id_12&showposts=1"); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-image-home">
					<a class="post-frame-channel <?php the_ID(); ?>" href="<?php echo $category_link_12; ?>" title="View all the video in: <?php echo get_cat_name($category_id_12); ?>"></a>
					<h4><?php echo get_cat_name($category_id_12); ?></h4>
					<?php the_post_thumbnail(); ?>
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php else : ?>
				<!-- nothing to see here -->
			<?php endif; ?>	
			</div>
		</div> <!-- channels-inside -->
	</div> <!-- channels -->
	
	<?php get_sidebar(); ?>
	
<?php get_footer(); ?>
