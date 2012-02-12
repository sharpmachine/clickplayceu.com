<?php

add_thickbox();

// Theme Location
define('THEME', get_bloginfo('template_url'), true);

// WordPress Custom Menu Suppot
add_theme_support( 'nav-menus' );

// WordPress Post Thumbnail Support
if (function_exists('add_theme_support')) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(200, 150, true);
}

// Load Required Theme Scripts
function theme_js() {
	if (is_admin()) return;
	wp_enqueue_script('jquery');
	wp_enqueue_script('superfish', THEME . '/scripts/superfish/jquery.superfish.js');
	wp_enqueue_style('coda', THEME . '/scripts/coda-slider/style.css');
	wp_enqueue_script('easing', THEME . '/scripts/coda-slider/jquery.easing.js', 'jquery');
	wp_enqueue_script('coda', THEME . '/scripts/coda-slider/jquery.coda.js', 'jquery');
	wp_enqueue_style('fancybox', THEME . '/scripts/fancybox/style.css');
	wp_enqueue_script('fancybox', THEME . '/scripts/fancybox/jquery.fancybox.js', 'jquery');
	wp_enqueue_script('ez-tooltip', THEME . '/scripts/ez-tooltip.js', 'jquery');
}
add_action('init', theme_js);

// Check for Simple Video Embedder
sve_check();

function sve_check()
{
	if ( !function_exists('p75GetVideo') )
	{
		add_thickbox(); // Required for the plugin install dialog.
		add_action('admin_notices', 'sve_check_notice');
	}
}

function sve_check_notice()
{
?>
	<div class='updated fade'>
		<p>The Simple Video Embedder plugin is required for this theme to function properly. <a href="<?php echo admin_url('plugin-install.php?tab=plugin-information&plugin=simple-video-embedder&TB_iframe=true&width=640&height=517'); ?>" class="thickbox onclick">Install now</a>.</p>
	</div>
<?php
}

// Check for Yoast Breadcrumbs
yb_check();

function yb_check()
{
	if ( !function_exists('yoast_breadcrumb') )
	{
		add_thickbox(); // Required for the plugin install dialog.
		add_action('admin_notices', 'yb_check_notice');
	}
}

function yb_check_notice()
{
?>
	<div class='updated fade'>
		<p>The Yoast Breadcrumbs plugin is required for this theme to function properly. <a href="<?php echo admin_url('plugin-install.php?tab=plugin-information&plugin=breadcrumbs&TB_iframe=true&width=640&height=517'); ?>" class="thickbox onclick">Install now</a>.</p>
	</div>
<?php
}

// Include Custom Theme Widgets
include("widgets/cat-posts.php");
include("widgets/related-posts.php");
include("widgets/simple-sidebar-ads.php");

// Theme Constants
define("THEME_PREFIX", "vidley_");

// The Admin Page
add_action('admin_menu', "sf_vidley_admin_init");

function sf_vidley_admin_init()
{
	add_theme_page( "Vidley Options", "Theme Options", 8, 'sf_vidley_admin_menu', 'sf_vidley_admin');
}

function sf_vidley_admin() {

	$option_fields = array();

	if ( $_GET['updated'] ) echo '<div id="message" class="updated fade"><p>Vidley Options Saved.</p></div>';
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/functions.css" type="text/css" media="all" />';
	
	// Accordion Script
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/scripts/accordion/style.css" type="text/css" media="all" />';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/accordion/jquery.ui.js" type="text/javascript"></script>';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/accordion/jquery.accordion.js" type="text/javascript"></script>';
	
	// Color Picker Script
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/scripts/colorpicker/style.css" type="text/css" media="all" />';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/colorpicker/jquery.colorpicker.js" type="text/javascript"></script>';
	echo '<script src="'.get_bloginfo('template_url').'/scripts/colorpicker/jquery.eye.js" type="text/javascript"></script>';
?>

<div class="wrap">
    <div id="icon-options-general" class="icon32"><br/></div>

    <h2>Vidley Theme Options</h2>

    <div class="metabox-holder">
    	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
    
        <div id="theme-options">
            <div id="accordion" class="postbox-container">
	            <?php 
	            	include("options/logo-options.php");
	            	include("options/navigation-options.php");
	            	include("options/header-advertisement.php");
	            	include("options/background-customization.php");
	            	include("options/text-link-colors.php");
	            	include("options/featured-content.php");
	            	include("options/featured-categories.php");
	        		include("options/footer-text.php");
	        		include("options/analytics-code.php");
	        		include("options/no-ie.php");
	        	?>
        	</div>  <!-- postbox-container -->
        </div> <!-- theme-options -->
        
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", $option_fields); ?>" />
        </form>
    </div>  <!-- metabox-holder -->
</div> <!-- wrap -->

<?php
}

// Custom Video Function
function get_video($postID) {
	if( function_exists('p75GetVideo') ) {
		$video = p75GetVideo($postID);
		return $video ? "<div class='video-embed'>" . $video . "</div>" : "";
	}
	return "";
}

// Menus Behind Embedded Video Fix
function add_video_wmode_transparent($html, $url, $attr) {
   if (strpos($html, "<embed src=" ) !== false) {
    	$html = str_replace('</param><embed', '</param><param name="wmode" value="transparent"></param><embed wmode="transparent" ', $html);
   		return $html;
   } else {
        return $html;
   }
}
add_filter('embed_oembed_html', 'add_video_wmode_transparent', 10, 3);

// Custom Styles Function
add_action( 'parse_request', 'sf_custom_css' );
function sf_custom_css($wp) {
    if (
        !empty( $_GET['sf-custom-content'] )
        && $_GET['sf-custom-content'] == 'css'
    ) {
        header( 'Content-Type: text/css' );
        require dirname( __FILE__ ) . '/style-custom.php';
        exit;
    }
}

// Custom Short Title Function
function the_short_title($before = '', $after = '', $echo = true, $length = false) {
	$title = get_the_title();
	
	if ( $length && is_numeric($length) ) {
		$title = substr( $title, 0, $length );
	}
	
	if ( strlen($title)> 0 ) {
		$title = apply_filters('the_short_title', $before . $title . $after, $before, $after);
		if ( $echo )
			echo $title;
		else
			return $title;
	}
}

// If More Than One Page Exists, Return TRUE
function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}

// Sidebar Widgets
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Home Page Left',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Home Page Center',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Home Page Right',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Multiple Post Pages Left',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Multiple Post Pages Center',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Multiple Post Pages Right',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Single Post Pages Left',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Single Post Pages Center',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Single Post Pages Right',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Page Pages Left',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Page Pages Center',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
register_sidebar(array('name'=>'Page Pages Right',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));

//Custom logo should be 16 x16
function custom_logo() {
  echo '<style type="text/css">
    #header-logo  { 
    	background-image: url('.get_bloginfo('template_directory').'/images/admin-logo.png) !important; 
	}
	
	.wrap div.updated, .wrap div.error {
		display: none;
	}
	#cpt_info_box {
		display: none !important; /* Hides Custom Post Type info box */
	}
    </style>';
}

add_action('admin_head', 'custom_logo');

function modify_footer_admin () {
  echo 'CLiCKceu is a service provided by Cosine Health Strategies.';
  echo '  Need Help?  <a href="../contact-us">Contact Us</a>.';
}

add_filter('admin_footer_text', 'modify_footer_admin');

if (!is_admin() && !current_user_can('add_users')){
add_filter( 'show_admin_bar', '__return_false' );
}

add_filter(  'gettext',  'register_text'  );
add_filter(  'ngettext',  'register_text'  );
function register_text( $translated ) {
     $translated = str_ireplace(  'Register',  'Sign Up',  $translated );
     return $translated;
}

// Create the function to output the contents of our Dashboard Widget
function help_dashboard_widget_function() {
	// Display whatever it is you want to show
	echo "
		<ul style=width:40%;float:left;margin-right:55px;min-width:153px;>
			<li style=color:#666;font-size:14px;border-bottom-style:solid;border-bottom-width:1px;border-bottom-color:#DFDFDF;padding-bottom:5px;margin-bottom:10px;>WordPress 101 Videos:</li>
			<li><a href=http://wp.tutsplus.com/tutorials/wp101-video-training-part-1-the-dashboard/ target=_blank>The Dashboard</a></li>
			<li><a href=http://wp.tutsplus.com/tutorials/wp-101-video-training-part-2-creating-a-new-post/ target=_blank>Creating A New Post</a></li>
			<li><a href=http://wp.tutsplus.com/tutorials/wp-101-video-training-part-3-edit-existing-post/ target=_blank>Edit Existing Post</a></li>
			<li><a href=http://wp.tutsplus.com/tutorials/wp-101-video-training-part-4-using-categories-and-tags/ target=_blank>Using Categories and Tag</a></li>
			<li><a href=http://wp.tutsplus.com/tutorials/wp-101-video-training-part-5-creating-and-editing-pages/ target=_blank>Creating and Editing Pages</a></li>
			<li><a href=http://wp.tutsplus.com/tutorials/wp-101-video-training-part-6-adding-images/ target=_blank>Adding Images &amp; Photos</a></li>
			<li><a href=http://wp.tutsplus.com/tutorials/wp-101-video-training-part-7-embedding-video/ target=_blank>How to Embed Video</a></li>
			<li><a href=http://wp.tutsplus.com/tutorials/wp-101-video-training-part-8-media-library/ target=_blank>Using the Media Library</a></li>
			<li><a href=http://wp.tutsplus.com/tutorials/wp-101-video-training-part-9-managing-comments/ target=_blank>Managing Comments</a></li> 
			<li><a href=http://wp.tutsplus.com/tutorials/wp-101-video-training-part-15-users/ target=_blank>Adding New Users</a></li>
		</ul>
		
		<ul style=width:40%;float:left;min-width:153px;>
			<li style=color:#666;font-size:14px;border-bottom-style:solid;border-bottom-width:1px;border-bottom-color:#DFDFDF;padding-bottom:5px;margin-bottom:10px;>Videos Specific To Your Site:</li>
			<li><a href=http://www.youtube.com/watch?v=IE_10_nwe0c target=_blank>SEO Ultimate Tutorial</a></li>
			<li><a href=http://youtu.be/BOnh7c6EshE target=_blank>Managing Videos</a></li>
			<li><a href=http://youtu.be/__GWhzE9Kao target=_blank>Managing Tests</a></li>
		</ul>
		
		<p style=clear:both;padding-top:5px;margin-bottom:0.5em;color:#666;font-size:14px;>Helpful Quick Links:</p>
		
		<a href=http://clickceu.com/analytics target=_blank>Analytics Login</a> 
		
		<p>Still stuck?  Give us a call at <strong>(480) 648-8229</strong> or email us at <a href=mailto:info@sharpmachinemedia.com?subject=Help!><strong>info@sharpmachinemedia.com</strong></a>.
	";
} 

// Create the function use in the action hook
function help_add_dashboard_widgets() {
	wp_add_dashboard_widget('help_dashboard_widget', 'Need Help?', 'help_dashboard_widget_function');	
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'help_add_dashboard_widgets' );

// navigation menu
if (function_exists('register_nav_menu')) {
register_nav_menu('primary', __('Footer'));
};


?>
