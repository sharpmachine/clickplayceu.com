<?php if ( is_home() ) { ?>
	<div id="sidebar-home">
		<div id="sidebar-home-inside">
			<div id="sidebar-left">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Page Left') ) : ?>
				<?php endif; ?>
			</div>
			
			<div id="sidebar-center">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Page Center') ) : ?>
				<?php endif; ?>
			</div>
			
			<div id="sidebar-right">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Page Right') ) : ?>
				<?php endif; ?>
			</div>
		</div>
	</div> <!-- sidebar-home -->
<?php } ?>

<?php if ( is_category() || is_search() ) { ?>
	<div id="sidebar-multiple">
		<div id="sidebar-multiple-inside">
			<div id="sidebar-left">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Multiple Post Pages Left') ) : ?>
				<?php endif; ?>
			</div>
			
			<div id="sidebar-center">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Multiple Post Pages Center') ) : ?>
				<?php endif; ?>
			</div>
			
			<div id="sidebar-right">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Multiple Post Pages Right') ) : ?>
				<?php endif; ?>
			</div>
		</div>
	</div> <!-- sidebar-multiple -->
<?php } ?>

<?php if ( is_single() ) { ?>
	<div id="sidebar-single">
		<div id="sidebar-left">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Single Post Pages Left') ) : ?>
			<?php endif; ?>
		</div>
		
		<div id="sidebar-center">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Single Post Pages Center') ) : ?>
			<?php endif; ?>
		</div>
		
		<div id="sidebar-right">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Single Post Pages Right') ) : ?>
			<?php endif; ?>
		</div>
	</div> <!-- sidebar-single -->
<?php } ?>

<?php if ( is_page() ) { ?>
	<div id="sidebar-page">
		<div id="sidebar-left">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Pages Left') ) : ?>
			<?php endif; ?>
		</div>
		
		<div id="sidebar-center">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Pages Center') ) : ?>
			<?php endif; ?>
		</div>
		
		<div id="sidebar-right">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Pages Right') ) : ?>
			<?php endif; ?>
		</div>
	</div> <!-- sidebar-pages -->
<?php } ?>
