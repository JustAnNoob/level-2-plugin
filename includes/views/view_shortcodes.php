<?php
/**
*	Description	of	view_shortcodes.php
*
*	@author	Tom Kuijper
*/
//	Add	the	main	view	shortcode
add_shortcode(	'BriefForm_main_view',	'load_main_view');

function load_main_view( $atts, $content = NULL){

 // Include the main view
 include BriefForm_PLUGIN_INCLUDES_VIEWS_DIR.
'/BriefForm_main_view.php';

}
?>