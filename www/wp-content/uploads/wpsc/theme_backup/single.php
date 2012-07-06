<?php get_header(); ?>
	<div id="content">
		<div id="content-inside">
			<div id="breadcrumbs">
				<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p>','</p>'); } ?>
				<?php include('searchform.php'); ?>
			</div>
			
			<div id="main-single">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class('single') ?>>
					<?php if ( get_post_meta($post->ID, "_videoembed", true) || get_post_meta($post->ID, "_videoembed_manual", true) ): ?>
					<div id="video-container-single">
						<div id="video-top">
							<!-- nothing to see here -->
						</div>
						
						<div id="post-nav">
							<div class="previous-post">
								<?php previous_post_link('%link', ' ', TRUE); ?>
							</div>
							
							<div id="video-single">
								<?php echo get_video($post->ID); ?>
								
								<div class="video-desc">
									<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									
									<?php the_excerpt(); ?>
								</div>
							</div> <!-- video -->
							
							<div class="next-post">
								<?php next_post_link('%link', ' ', TRUE); ?>
							</div>
						</div>
						
						<div id="video-bottom">
							<!-- nothing to see here -->
						</div>
					</div> <!-- video-container -->
					<?php else : ?>
						<!-- no video on this post -->
					<?php endif; ?>
				
					<div class="post-meta">
						<div class="post-image">
							<?php if ( get_post_meta($post->ID, "_videoembed", true) || get_post_meta($post->ID, "_videoembed_manual", true) ): ?>
							<a class="post-frame-video" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"></a>
							<?php else : ?>
							<a class="post-frame-post" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"></a>
							<?php endif; ?>
							
							<?php the_post_thumbnail(); ?>
						</div>
						
						<ul class="details">
							<li><span class="date"><?php the_time('F j, Y'); ?></span></li>
							<li><span class="author">Posted by: <?php the_author(); ?></span></li>
							<li><span class="comments"><?php comments_number('No Comments','One Comment','% Comments'); ?></span></li>
							<li><span class="category"><?php the_category(', ') ?></span></li>
							<?php if (has_tag()): ?>
							<li><span class="tags"><?php the_tags(''); ?></span></li>
							<?php endif; ?>
						</ul>
					</div>
					
					<div class="entry-single">
						<?php if ( get_post_meta($post->ID, "_videoembed", true) || get_post_meta($post->ID, "_videoembed_manual", true) ): ?>
							<!-- nothing to see here -->
						<?php else : ?>
							<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<?php endif; ?>
						
						<?php the_content('Continue Reading'); ?>
						
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					</div>
				</div> <!-- post -->
				
				<?php comments_template(); ?>
				
				<div class="divider-top">
					<!-- nothing to see here -->
				</div>	
				
				<?php endwhile; ?>
			<?php else : ?>
			
				<div class="single">
					<h2>Sorry, but you are looking for something that isn't here.</h2>
				</div>
				
			<?php endif; ?> 
			</div> <!-- main-single -->
			
			<?php get_sidebar(); ?>
		</div> <!-- content-inside -->
	</div> <!-- content -->

<?php get_footer(); ?>
