<?php
/*
Plugin Name: Simple Sidebar Ads
Plugin URI: http://jameslao.com/
Description: Ads a widget that shows four 125x125 px ads.
Author: James Lao	
Version: 1.0
Author URI: http://jameslao.com/
*/

define('P75_SSA_OPTION_KEY', 'p75_sidebar_ads');
define('P75_SSA_ID_BASE', 'p75-sidebar-ads');
define('P75_SSA_NUM_ADS', 4);

// Displays widget on blag
// $widget_args: number
//    number: which of the several widgets of this type do we mean
function p75_sidebar_ads_widget( $args, $widget_args = 1 ) {
	extract( $args, EXTR_SKIP );
	if ( is_numeric($widget_args) )
		$widget_args = array( 'number' => $widget_args );
	$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
	extract( $widget_args, EXTR_SKIP );
	
	// Data should be stored as array:  array( number => data for that instance of the widget, ... )
	$options = get_option(P75_SSA_OPTION_KEY);
	if ( !isset($options[$number]) )
		return;
	
	$cat_id = empty($options[$number]['cat']) ? 1 : $options[$number]['cat'];
	$title_link = (bool) $options[$number]['title_link'];
	$excerpt = (bool) $options[$number]['excerpt'];
	$num = $options[$number]['num']; // Number of posts to show.
	$show_thumbnail = (bool) $options[$number]['thumbnail'];
	

	
	echo $before_widget;
	
	if ( $options[$number]['title'] )
		echo $before_title . $options[$number]['title'] . $after_title;
	else
		echo "";
	
	for ($i=1; $i<=P75_SSA_NUM_ADS; $i++)
	{
		if ( $options[$number]["ad_{$i}_image"] )
		{
			if ( $options[$number]["ad_{$i}_link"] )
				echo "<a href='" . $options[$number]["ad_{$i}_link"] . "'>";
			echo "<img class='sidebar-ad' src='" . $options[$number]["ad_{$i}_image"] . "' alt='Advertisement' />";
			if ( $options[$number]["ad_{$i}_link"] )
				echo "</a>";
		}
		else
		{
			if ( $options[$number]["default_ad_link"] )
				echo "<a href='" . $options[$number]["default_ad_link"] . "'>";
			echo "<img class='sidebar-ad' src='" . $options[$number]["default_ad_image"] . "' alt='Advertisement' />";
			if ( $options[$number]["default_ad_link"] )
				echo "</a>";
		}
	}

	echo $after_widget;
}

// Displays form for a particular instance of the widget.  Also updates the data after a POST submit
// $widget_args: number
//    number: which of the several widgets of this type do we mean
function p75_sidebar_ads_control( $widget_args = 1 ) {
	global $wp_registered_widgets;
	static $updated = false; // Whether or not we have already updated the data after a POST submit

	if ( is_numeric($widget_args) )
		$widget_args = array( 'number' => $widget_args );
	$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
	extract( $widget_args, EXTR_SKIP );

	// Data should be stored as array:  array( number => data for that instance of the widget, ... )
	$options = get_option(P75_SSA_OPTION_KEY);
	if ( !is_array($options) )
		$options = array();

	// We need to update the data
	if ( !$updated && !empty($_POST['sidebar']) ) {
		// Tells us what sidebar to put the data in
		$sidebar = (string) $_POST['sidebar'];

		$sidebars_widgets = wp_get_sidebars_widgets();
		if ( isset($sidebars_widgets[$sidebar]) )
			$this_sidebar =& $sidebars_widgets[$sidebar];
		else
			$this_sidebar = array();

		foreach ( $this_sidebar as $_widget_id ) {
			// Remove all widgets of this type from the sidebar.  We'll add the new data in a second.  This makes sure we don't get any duplicate data
			// since widget ids aren't necessarily persistent across multiple updates
			if ( 'p75_sidebar_ads_widget' == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number']) ) {
				$widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
				if ( !in_array( P75_SSA_ID_BASE . "-$widget_number", $_POST['widget-id'] ) ) // the widget has been removed. "many-$widget_number" is "{id_base}-{widget_number}
					unset($options[$widget_number]);
			}
		}
		
		foreach ( (array) $_POST[P75_SSA_ID_BASE] as $widget_number => $ssa_instance )
		{
			// compile data from $widget_many_instance
			$options[$widget_number] =
				array
				(
					'title' => wp_specialchars( $ssa_instance['title'] ),
					'default_ad_image' => $ssa_instance['default_ad_image'],
					'default_ad_link' => $ssa_instance['default_ad_link']
				);
			for ($i=1; $i<=P75_SSA_NUM_ADS; $i++)
			{
				$options[$widget_number]["ad_{$i}_image"] = $ssa_instance["ad_{$i}_image"];
				$options[$widget_number]["ad_{$i}_link"] = $ssa_instance["ad_{$i}_link"];
			}
		}
		
		update_option('p75_sidebar_ads', $options);
		
		$updated = true; // So that we don't go through this more than once
	}
	
	
	// Here we echo out the form
	if ( -1 == $number ) { // We echo out a template for a form which can be converted to a specific form later via JS
		$number = '%i%';
		$title = "";
		$default_ad_image = "";
		$default_ad_link = "";
		for ($i=1; $i<=P75_SSA_NUM_ADS; $i++)
		{
			$ads["ad_{$i}_image"] = "";
			$ads["ad_{$i}_link"] = "";
		}
	} else {
		$title = attribute_escape($options[$number]['title']);
		$default_ad_image = $options[$number]["default_ad_image"];
		$default_ad_link = $options[$number]["default_ad_link"];
		for ($i=1; $i<=P75_SSA_NUM_ADS; $i++)
		{
			$ads["ad_{$i}_image"] = $options[$number]["ad_{$i}_image"];
			$ads["ad_{$i}_link"] = $options[$number]["ad_{$i}_link"];
		}
	}

	// The form has inputs with names like widget-many[$number][something] so that all data for that instance of
	// the widget are stored in one $_POST variable: $_POST['widget-many'][$number]
?>
		<p>
			<label for="<?php echo P75_SSA_ID_BASE."-title-$number"; ?>">
				<?php _e( 'Title:' ); ?>
				<input class="widefat" id="<?php echo P75_SSA_ID_BASE."-title-".$number; ?>" name="<?php echo P75_SSA_ID_BASE."[$number][title]"; ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
		<table style="width:96%;">
			<tr>
				<th>Ad</th>
				<th>Image</th>
				<th>Link</th>
			</tr>
			<?php
				for ( $i=1; $i<=P75_SSA_NUM_ADS; $i++ )
				{
					echo "<tr>\n";
					echo "<td style='padding: 8px;'>$i.</td>\n";
					echo "<td><input class='widefat' name='" . P75_SSA_ID_BASE . "[$number][ad_{$i}_image]' type='text' value='" . $ads["ad_{$i}_image"] . "' />\n";
					echo "<td><input class='widefat' name='" . P75_SSA_ID_BASE . "[$number][ad_{$i}_link]' type='text' value='" . $ads["ad_{$i}_link"] . "' />\n";
					echo "</tr>\n";
				}
			?>
			<tr>
				<th colspan='3'>Default Advertisement</th>
			</tr>
			<tr>
				<td></td>
				<td><input class="widefat" name="<?php echo P75_SSA_ID_BASE."[$number][default_ad_image]"; ?>" type="text" value="<?php echo $default_ad_image; ?>" /></td>
				<td><input class="widefat" name="<?php echo P75_SSA_ID_BASE."[$number][default_ad_link]"; ?>" type="text" value="<?php echo $default_ad_link; ?>" /></td>
			</tr>
		</table>
		<input type="hidden" id="<?php echo P75_SSA_ID_BASE."-submit-$number"; ?>" name="<?php echo P75_SSA_ID_BASE."[$number][submit]"; ?>" value="1" />

<?php

}

// Registers each instance of our widget on startup
function p75_sidebar_ads_register() {
	if ( !$options = get_option(P75_SSA_OPTION_KEY) )
		$options = array();

	$widget_ops = array('classname' => 'p75_sidebar_ads', 'description' => __('Configure and display up to four 125x125 sidebar advertisements.'));
	$control_ops = array('id_base' => P75_SSA_ID_BASE, 'width'=>350);
	$name = __('Simple Sidebar Ads');

	$registered = false;
	foreach ( array_keys($options) as $o ) {
		// Old widgets can have null values for some reason
		if ( !isset($options[$o]['title']) ) // we used 'something' above in our exampple.  Replace with with whatever your real data are.
			continue;

		// $id should look like {$id_base}-{$o}
		$id = P75_SSA_ID_BASE . "-$o"; // Never never never translate an id
		$registered = true;
		wp_register_sidebar_widget( $id, $name, 'p75_sidebar_ads_widget', $widget_ops, array( 'number' => $o ) );
		wp_register_widget_control( $id, $name, 'p75_sidebar_ads_control', $control_ops, array( 'number' => $o ) );
	}

	// If there are none, we register the widget's existance with a generic template
	if ( !$registered ) {
		wp_register_sidebar_widget( P75_SSA_ID_BASE . '-1', $name, 'p75_sidebar_ads_widget', $widget_ops, array( 'number' => -1 ) );
		wp_register_widget_control( P75_SSA_ID_BASE . '-1', $name, 'p75_sidebar_ads_control', $control_ops, array( 'number' => -1 ) );
	}
}

// This is important
add_action( 'widgets_init', 'p75_sidebar_ads_register' );

?>
