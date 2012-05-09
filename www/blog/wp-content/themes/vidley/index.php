<?php get_header(); ?>
	
	<div id="content">
		<div id="content-inside">
			<div id="breadcrumbs">
				<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p>','</p>'); } ?>
				<?php include('searchform.php'); ?>
			</div> <!-- breadcrumbs -->
			
			<div id="main-multiple">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class('multiple') ?>>
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
					</div> <!-- post-meta -->			
					
					<div class="entry-multiple">
						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						
						<?php the_content('Continue Reading'); ?>
					</div> <!-- entry-multiple -->
				</div> <!-- post -->
				
				<?php endwhile; ?>
				
				<?php if (show_posts_nav()) : ?>
				<div id="pagination">
					<div id="nav-forward"><p><?php previous_posts_link('Newer Entries') ?></p></div>
					<div id="nav-back"><p><?php next_posts_link('Older Entries') ?></p></div>
				</div>
				<?php endif; ?>
				
			<?php else : ?>
			
				<div class="single">
					<h2>Sorry, but you are looking for something that isn't here.</h2>
				</div>
				
			<?php endif; ?> 
			</div> <!-- main-multiple -->
			
			<div class="divider-bottom">
				<!-- nothing to see here -->
			</div>
			
			<?php get_sidebar(); ?>
		</div> <!-- content-inside -->
	</div> <!-- content -->

<?php get_footer(); ?>