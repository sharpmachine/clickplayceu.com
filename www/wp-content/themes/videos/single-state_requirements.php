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
						<?php the_content(); ?>
						
						<p>Select your profession to quickly jump to that section.</p>
						
						<ul class="profession-list">
							<li><a href="#registered_nurse">Registered Nurse</a></li>
							<li><a href="#residential_facility_for_the_elderly">Residential Facility for the Elderly</a></li>
							<li><a href="#certified_nursing_assistant">Certified Nursing Assistant</a></li>
							<li><a href="#nursing_home_administrator">Nursing Home Administrator</a></li>
							<li><a href="#supported_living_services">Supported Living Services</a></li>
						</ul>
						
						
						<ul class="profession-list">
							<li><a href="#assisted_living_administrator">Assisted Living Administrator</a></li>
							<li><a href="#licensed_vocational_nurses">Licensed Vocational Nurses</a></li>
							<li><a href="#psychiatric_technicians">Psychiatric Technicians</a></li>
							<li><a href="#group_home">Group Home</a></li>
							<li><a href="#adult_residential_facility">Adult Residential Facility</a></li>
						</ul>
						<div class="clear"></div>
						
						<h3 id="registered_nurse">Registered Nurse</h3>
						<?php the_field('registered_nurse'); ?>
						
						<h3 id="residential_facility_for_the_elderly">Residential Facility for the Elderly</h3>
						<?php the_field('residential_facility_for_the_elderly'); ?>
						
						<h3 id="certified_nursing_assistant">Certified Nursing Assistant</h3>
						<?php the_field('certified_nursing_assistant'); ?>
						
						<h3 id="nursing_home_administrator">Nursing Home Administrator</h3>
						<?php the_field('nursing_home_administrator'); ?>
						
						<h3 id="supported_living_services">Supported Living Services</h3>
						<?php the_field('supported_living_services'); ?>
						
						<h3 id="assisted_living_administrator">Assisted Living Administrator</h3>
						<?php the_field('assisted_living_administrator'); ?>
						
						<h3 id="licensed_vocational_nurses">Licensed Vocational Nurses</h3>
						<?php the_field('licensed_vocational_nurses'); ?>
						
						<h3 id="psychiatric_technicians">Psychiatric Technicians</h3>
						<?php the_field('psychiatric_technicians'); ?>
						
						<h3 id="group_home">Group Home</h3>
						<?php the_field('group_home'); ?>
						
						<h3 id="adult_residential_facility">Adult Residential Facility</h3>
						<?php the_field('adult_residential_facility'); ?>
						
						
						
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					</div>
				</div> <!-- post -->
				
				<?php endwhile; ?>
			<?php else : ?>
			
				<div class="single-postorpage">
					<h2>Sorry, but you are looking for something that isn't here.</h2>
				</div>
				
			<?php endif; ?> 
			
			
					</div>
					
				</div> <!-- channels-inside -->
			</div> <!-- channels -->
			
			</div> <!-- main-page -->
			


		</div> <!-- content-inside -->
	</div> <!-- content -->

<?php get_footer(); ?>
