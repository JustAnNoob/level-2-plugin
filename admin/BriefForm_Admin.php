<?php
/**
* This Admin controller file provide functionality for the Admin section of the
* 
*
* @author Tom Kuijper
* @version 1.0
*
* Version history
* 1.0 Tom Kuijper Initial version
*/
class BriefForm_Admin {
	/**
	* This function will prepare all Admin functionality for the plugin
	*/
	static function prepare() {
	// Check that we are in the admin area
	if( is_admin() ) :
	// Add the sidebar Menu structure
	add_action( 'admin_menu', array( 'BriefForm_Admin',
	'addMenus' ) );
	endif;
	}
	/**
	* Add the Menu structure to the Admin sidebar
	*/
	static function addMenus() {
	add_menu_page(
	// string $page_title The text to be displayed in the title tags
	// of the page when the menu is selected
	__( 'BriefForm Admin', 'BriefForm'),
	// string $menu_title The text to be used for the menu
	__( 'BriefForm Admin', 'BriefForm' ),
	// string $capability The capability required for this menu to be displayed to the user.
	'manage_options',
	// string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
	 'BriefForm-admin',
	// callback $function The function to be called to output the content for this page.
	array( 'BriefForm_Admin', 'adminMenuPage'),
	// string $icon_url The url to the icon to be used for this menu.
	// * Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme.
	// This should begin with 'data:image/svg+xml;base64,'.
	// * Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'.
	// * Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
	'dashicons-feedback'
	// int $position The position in the menu order this one should appear
	);
	add_submenu_page (
	// string $parent_slug The slug name for the parent menu
	// (or the file name of a standard WordPress admin page)
	'BriefForm-admin',
	// string $page_title The text to be displayed in the title tags of the page when the menu is selected
	__( 'Briefjes_aanmaak', 'BriefForm' ),
	// string $menu_title The text to be used for the menu
	__( 'Briefjes aanmaken', 'BriefForm'),
	// string $capability The capability required for this menu to be displayed to the user.
	'manage_options',
	// string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
	'tf_admin_Briefjes_aanmaak',
	// callback $function The function to be called to output the content for this page.
	array( 'BriefForm_Admin', 'adminSubMenuBriefjes' )
	);
	}
	/**
	* The main menu page
	*/
	static function adminMenuPage() {
	// Include the view for this menu page.
	include BriefForm_PLUGIN_ADMIN_VIEWS_DIR . '/admin_main.php';
	}
	static function adminSubMenuBriefjes() {
	// include the view for this submenu page.
	include BriefForm_PLUGIN_ADMIN_VIEWS_DIR .
	'/tf_admin_Briefjes_aanmaak.php';
	}
}
?>