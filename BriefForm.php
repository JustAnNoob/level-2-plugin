<?php
defined( 'ABSPATH' ) OR exit;

/**
 * Plugin Name: BriefForm
* Plugin URI:
* Description:
* Author: Tom Cornelis Kuijper
* Author URI: http://tom.media-portfolios.nl
* Version: 1.0
* Text Domain: BriefForm
* Domain Path: languages
*
* This is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with your plugin. If not, see <http://www.gnu.org/licenses/>.
*/
// Define the plugin name:
define ( 'BriefForm_PLUGIN', __FILE__ );

// Include the general definition file:
require_once plugin_dir_path( __FILE__ ) . 'includes/defs.php';

/* Register the hooks */
register_activation_hook( __FILE__, array( 'BriefForm',
'on_activation' ) );
register_deactivation_hook( __FILE__, array( 'BriefForm',
'on_deactivation' ) );

// include install script
function installer() {
	include_once('loaders/installer.php');
}
// include uninstall script
function uninstaller() {
	include_once('loaders/uninstaller.php');
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'installer');
register_activation_hook(__FILE__,'install_tables');

// run the uninstall scripts upon plugin activation
register_deactivation_hook(__FILE__,'uninstaller');
register_deactivation_hook( __FILE__, 'uninstall_tables' );

class BriefForm {
	public function __construct() {
		// Fire a hook before the class is setup.
		do_action( 'BriefForm_pre_init' );
		// Load the plugin.
		add_action( 'init', array( $this, 'init' ), 1 );
	}
	public static function on_activation()
	 {
	 if ( ! current_user_can( 'activate_plugins' ) )
	 return;
	 $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	 check_admin_referer( "activate-plugin_{$plugin}" );
	 
	 // Add the theme capabilities
	 BriefForm::add_plugin_caps();
	 
	 # Uncomment the following line to see the function in action
	 # exit( var_dump( $_GET ) );
	 }
	 public static function on_deactivation()
	 {
	 if ( ! current_user_can( 'activate_plugins' ) )
	 return;
	 $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	 check_admin_referer( "deactivate-plugin_{$plugin}" );
	 
	 // Remove the theme specific capabilities
	 BriefForm::remove_plugin_caps();
	 
	 # Uncomment the following line to see the function in action
	 # exit( var_dump( $_GET ) );
	 }
	/**
	* Loads the plugin into WordPress.
	*
	* @since 1.0.0
	*/
	public function init() {
	// Run hook once Plugin has been initialized.
	do_action( 'BriefForm_init' );
	// Load admin only components.
	if ( is_admin() ) {
	// Load all admin specific includes
	$this->requireAdmin();
	// Setup admin page
	$this->createAdmin();
	}
	// Load the view shortcodes
	$this->loadViews();
	}
	/**
	* Loads all admin related files into scope.
	*
	* @since 1.0.0
	*/
	public function requireAdmin() {
	// Admin controller file
	require_once BriefForm_PLUGIN_ADMIN_DIR.
	'/BriefForm_Admin.php';
	}
	/**
	* Admin controller functionality
	*/
	public function createAdmin(){
	BriefForm_Admin::prepare();
	}
	
	/**
	 * Load the view shortcodes:
	 */
	 public function loadViews() {

	 include BriefForm_PLUGIN_INCLUDES_VIEWS_DIR. '/view_shortcodes.php';

	 }
	 
	 /*
	 * Define the array with plugin specific capabilities per role.
	 *
	 */
	 public static function get_plugin_roles_and_caps(){

	 // Define the desired roles for this plugin:
	 return array (
	 /* Is always available - Should be on firsth line */
	 array('administrator',
	 'Admin',
	 array( 'Briefjes_overzicht',
	 'Briefjes_bestellen',
	 'Briefjes_lezen',
	'bestelling_overzicht') ),

	 array('manager',
	 'Manager',
	 array( 'Briefjes_overzicht',
	 'Briefjes_bestellen',
	 'Briefjes_lezen',
	'bestelling_overzicht') ),

	 array('projectlid',
	 'Project lid',
	array( 'Briefjes_bestellen',
	'Briefjes_overzicht',
	'Briefjes_lezen') )
	 );

	 }
	 
	 /**
	 * Add plugin specific capabilities
	 * Check firsth for the specific roles
	 * If they not exists add specific roles
	 * Add plugin specific caps per role
	 *
	 */
	 public static function add_plugin_caps() {

	 // Include the roles and capabilities definition file:
	 require_once plugin_dir_path( __FILE__ ) .
	'includes/roles_and_caps_defs.php';

	 $role_array = BriefForm::get_plugin_roles_and_caps();

	 // Check for the roles:
	 foreach ($role_array as $key => $role_name) {
	 // Check specific role
	 if( !( $GLOBALS['wp_roles']->is_role(
	$role_name[ROLE_NAME] )) ){

	// Create role
	$role = add_role($role_name[ROLE_NAME],
	$role_name[ROLE_ALIAS], array('read' => true, 'level_0' => true));
	 }
	 // else : role exists
	 }

	 #exit( var_dump( $_GET ). var_dump($role) );

	 // Add the capabilities per role
	 foreach ($role_array as $key => $role_name) {
	 // Create the caps for this role
	 foreach ($role_name[ROLE_CAP_ARRAY] as $cap_key =>
	$cap_name) {
	 // gets the author role
	 $role = get_role( $role_name[ROLE_NAME] );
	 // This only works, because it accesses the class instance.
	// would allow the author to edit others' posts for current theme only
	 $role->add_cap( $cap_name );
	 }
	 }
	 }
	 
	 
	 /**
	 *
	 * Remove all the specific capabilities for this plugin.
	 *
	 *
	 *
	 */
	 public static function remove_plugin_caps(){

	 // Include the roles and capabilities definition file:
	 require_once plugin_dir_path( __FILE__ ) .
	'includes/roles_and_caps_defs.php';

	 // Get the plugin specific capabilities per role
	 $role_array = BriefForm::get_plugin_roles_and_caps();

	 // Add the capabilities per role
	 foreach ($role_array as $key => $role_name) {
	 // Create the caps for this role
	 foreach ($role_name[ROLE_CAP_ARRAY] as $cap_key =>
	$cap_name) {
		// gets the specific role
	$role = get_role( $role_name[ROLE_NAME] );
	 // This only works, because it accesses the class instance.
	// would allow the author to edit others' posts for current theme only
	 $role->remove_cap( $cap_name );
	 }
	 }
	 }
	 
}
// Instantiate the class
$event_form = new BriefForm();
?>