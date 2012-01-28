<?php get_header(); ?>
	<div id="content">
		<div id="content-inside">
			<!-- <div id="breadcrumbs">
				<p><?php //echo get_option(THEME_PREFIX . "tagline_text"); ?></p>
				<?php //include('searchform.php'); ?>
			</div> --> <!-- breadcrumbs -->
		
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
				<h2>CLiCKceu makes it as easy as 1 - 2 - 3 to continue your medical education.</h2>
				<div class="col">
					<h3><span>1</span> Take the Pre-Test.</h3>
					<p>The pre-test is designed to determine your pre-existing knowledge base. It also functions to give you an idea about where this course will be heading.</p>
					<img src="<?php bloginfo('template_directory'); ?>/images/test.jpg" width="280" height="186" alt="Test">
				</div>
				<div class="col">
					<h3><span>2</span> Watch the Video Training.</h3>
					<p>Simply watch the training video for the certification you are seeking.  From there you are well on your way to an amazing education experience!</p>
					<img src="<?php bloginfo('template_directory'); ?>/images/watch-videos.jpg" width="280" height="186" alt="Watch Videos">
				</div>
				<div class="col last">
					<h3><span>3</span> Pass the Final Test.</h3>
					<p>Pass the final test with 70% or better. Once you’ve passed and completed the checkout process your certificate of completion will be sent to you instantly via e-mail.</p>
					<img src="<?php bloginfo('template_directory'); ?>/images/final-exam.jpg" width="280" height="186" alt="Test">
				</div>
				
			</div>
	
	<div id="channels" class="clear" style="margin-top: 30px;">
		<div id="channels-inside">
			<div id="channels-wrapper">
			<!-- featured category #1 -->
			<h2>Select a Course.</h2>
			<?php 
				// $args = array(
				 // 								'cat' 	=> array(-4,8,9),
				 // 								'posts_per_page' => 4,
				 // 								'order'	=> 'DESC'				
				 // 				);
				 // 				query_posts($args); ?>
				
				<?php query_posts("cat=8,9&cat=-4,-3&posts_per_page=4&order=DESC"); ?>
				
				<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
				<div class="post-image-home">
					
					<?php
						$str = get_the_excerpt(); 
								$n = 50;
								//$delim = '...';
								$tooltip = get_the_excerpt() . '<br /> <strong>Approved By: </strong>';
								$count = 0;
								foreach((get_the_category()) as $category) { 
									if (cat_is_ancestor_of(14, $category->cat_ID))  { 
										if (count(get_the_category()) === $count + 1) {
											$tooltip .= $category->category_description; 
										} else { 
											$tooltip .= $category->category_description . ', ';
										}
									}
									$count++;
								} 

					?>
					<a class="post-frame-channel <?php the_ID(); ?> qtip" href="<?php the_permalink(); ?>" title="<?php echo $tooltip ?>"></a>
					
						<ul>
							<li><?php the_post_thumbnail(); ?></li>
							<!--  <li><?php //the_time('F jS, Y') ;?></li>-->
							<li class="title"><?php the_title() ;?></li>
							<li class="excerpt"><?php 
								//$delim = '... <a class="tooltip" href="'.get_permalink().'" title="'. get_the_excerpt().'">Read More</a>'; 
								$delim = '... <a class="qtip" href="'.get_permalink().'" title="'.$tooltip.'"> More</a>';
						   		$len = strlen($str);
								if ($len > $n) {
								    preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
								    echo rtrim($matches[1]) . $delim;
								} else {
									echo $str;
								}
								?>
							</li> 
							<?php 
								$total = get_post_meta(get_post_meta($id, 'ProductID', true), '_wpsc_price', true);
								//$price = "$".number_format($total, 2, '.', ','); ?>
							<li class="price"><span class="dollar">$</span><?php echo $total; ?></li>
							<li class="credits">(<?php echo get_post_meta(get_post_meta($id, 'ProductID', true), 'Credits', true); ?>) Credit Hours</li>
							
						</ul>
					
				</div>	
				<?php endwhile; else: ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			<?php // else : ?>
				<!-- nothing to see here -->
			<?php //endif; ?>
			
			</div>
			
		</div> <!-- channels-inside -->
	</div> <!-- channels -->
	
	
	
<?php get_footer(); ?>
