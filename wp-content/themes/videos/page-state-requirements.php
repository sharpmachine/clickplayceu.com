<?php get_header(); ?>

	<div id="content">
		<div id="content-inside">
			<!-- <div id="breadcrumbs">
				<?php //if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p>','</p>'); } ?>
				<?php //include('searchform.php'); ?>
			</div> -->
			
			<div id="main-page">
			<div id="channels">
				<div id="channels-inside">
					<div id="channels-wrapper">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class('single-page') ?>>
					<h2><?php the_title(); ?></h2>
					
					<div class="entry">
						<?php the_content('Continue Reading'); ?>
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					</div>

				
				<?php endwhile; endif; ?> 
			
			
							<?php query_posts('post_type=state_requirements'); ?>

<div class="req-col">
<?php $count = 0;
 
while(have_posts()) : the_post();
?>

<?php if ($count % 14 == 0 && $count != 0): ?>
</div>
<div class="req-col">
<?php endif; ?>
 
<div class="box">
 
<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
 
</div>
 
<?php 
$count++;
endwhile;
?>
</div>

					
						
						
						

				</div>
				
					</div>
					
				</div> <!-- channels-inside -->
			</div> <!-- channels -->
			
			</div> <!-- main-page -->
			


		</div> <!-- content-inside -->
	</div> <!-- content -->

<?php get_footer(); ?>
