<?php
// Press75.com
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<!--
**********************************************************************************************

Designed and Built by Jason Schuller - theSevenFive.com

CSS, XHTML and Design Files are all Copyright 2007-2010 Circa75 Media, LLC

Be inspired, but please don't steal...

**********************************************************************************************
-->

<head profile="http://gmpg.org/xfn/11">
	<!-- page titles -->
	<title>
	<?php if ( is_home() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php bloginfo('description'); ?><?php } ?>
	<?php if ( is_search() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Search Results<?php } ?>
	<?php if ( is_author() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Author Archives<?php } ?>
	<?php if ( is_single() ) { ?><?php wp_title(''); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
	<?php if ( is_page() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php wp_title(''); ?><?php } ?>
	<?php if ( is_category() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php single_cat_title(); ?><?php } ?>
	<?php if ( is_month() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php the_time('F'); ?><?php } ?>
	<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Tag Archive&nbsp;|&nbsp;<?php  single_tag_title("", true); } } ?>
	</title>
	
	<!-- meta tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<meta name="description" content="<?php the_excerpt_rss(); ?>" />
	<?php endwhile; endif; elseif(is_home()) : ?>
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<?php endif; ?>
	
	<!-- import required theme styles -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css3.css" type="text/css" media="screen" />
	
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-ie7.css" type="text/css" media="screen" />
	<![endif]-->
	
	<!-- custom theme styles if there are any -->
	<link rel='stylesheet' type='text/css' href="<?php bloginfo('url'); ?>/?sf-custom-content=css" />
	
	<!-- rss, pingback url and favicon link -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon" />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>
	
	<?php if (get_option(THEME_PREFIX . "analytics_code")) { ?>
		<?php echo get_option(THEME_PREFIX . "analytics_code"); ?>
	<?php } ?>
</head>

<body>
	<div id="header">
		<div id="header-inside">
			<div id="header-left">
    		<?php if ( get_option(THEME_PREFIX . "logo_txt") ) : ?>
    			<h1><a href="http://clickplayceu.com" title="Home" ><?php echo get_option(THEME_PREFIX . "logo_txt"); ?></a></h1>
    		<?php else : ?>
    			<a href="http://clickplayceu.com" title="Home" ><img src="<?php echo ($logo = get_option(THEME_PREFIX . 'logo_img')) ? $logo : get_bloginfo("template_url") . "/images/logo.png"; ?>" alt="<?php bloginfo('name'); ?>" /></a>
    		<?php endif; ?>
			</div> <!-- header-left -->
			
			<div id="header-right">
				<?php if (get_option(THEME_PREFIX . "menu_management")) : ?>
				<?php wp_nav_menu(array('sort_column' => 'menu_order', 'container_class' => 'menu-header')); ?>
				<?php else : ?>
				<ul class="menu">
					<li <?php if (is_home()) { echo 'class="selected"'; } ?>><a href="<?php echo get_option('home'); ?>/" title="Home">Home</a></li>
					
					<?php wp_list_categories('title_li='); ?>
					
					<?php wp_list_pages('title_li='); ?>
									
					<?php if (get_option(THEME_PREFIX . "twitter_link")) { ?>
					<li class="twitter"><a href="http://twitter.com/<?php echo get_option(THEME_PREFIX . "twitter_link"); ?>" title="Twitter.com">Twitter</a></li>
					<?php } ?>
					
					<li class="subscribe"><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe via RSS">Subscribe</a></li>
				</ul>
				<?php endif; ?>
				
				<?php if (get_option(THEME_PREFIX . "header_ad")) { ?>
					<?php echo ($header_ad = get_option(THEME_PREFIX . 'header_ad')); ?>
				<?php } ?>
			</div> <!-- header-right -->
		</div> <!-- header-inside -->
	</div> <!-- header -->