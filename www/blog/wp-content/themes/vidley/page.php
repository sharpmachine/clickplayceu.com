<?php get_header(); ?>

	<div id="content">
		<div id="content-inside">
			<div id="breadcrumbs">
				<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p>','</p>'); } ?>
				<?php include('searchform.php'); ?>
			</div>
			
			<div id="main-page">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class('single-page') ?>>
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					
					<div class="entry">
						<?php the_content('Continue Reading'); ?>
						
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					</div>
				</div> <!-- post -->
				
				<?php endwhile; ?>
			<?php else : ?>
			
				<div class="single">
					<h2>Sorry, but you are looking for something that isn't here.</h2>
				</div>
				
			<?php endif; ?> 
			</div> <!-- main-page -->
			
			<div class="divider-top">
				<!-- nothing to see here -->
			</div>	
			
			<?php get_sidebar(); ?>
		</div> <!-- content-inside -->
	</div> <!-- content -->

<?php get_footer(); ?>