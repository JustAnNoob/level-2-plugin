<?php
/**
* Definitions needed in the plugin
*
* @author
* @version 1.0
*
* Version history
* 1.0 Initial version
*/
// De versie moet gelijk zijn met het versie nummer in de BriefForm.php header
define( 'BriefForm_VERSION', '1.0' );
// Minimum required Wordpress version for this plugin
define( 'BriefForm_REQUIRED_WP_VERSION', '4.0');
define( 'BriefForm_PLUGIN_BASENAME', plugin_basename(BriefForm_PLUGIN));
define( 'BriefForm_PLUGIN_NAME', trim( dirname(BriefForm_PLUGIN_BASENAME ), '/'));
// Folder structure
define( 'BriefForm_PLUGIN_DIR', untrailingslashit( dirname(BriefForm_PLUGIN)));
define( 'BriefForm_PLUGIN_INCLUDES_DIR',BriefForm_PLUGIN_DIR . '/includes');
define(	'BriefForm_PLUGIN_INCLUDES_VIEWS_DIR',	BriefForm_PLUGIN_INCLUDES_DIR . '/views');
define( 'BriefForm_PLUGIN_MODEL_DIR',BriefForm_PLUGIN_INCLUDES_DIR . '/model');
define( 'BriefForm_PLUGIN_ADMIN_DIR',BriefForm_PLUGIN_DIR . '/admin');
define( 'BriefForm_PLUGIN_ADMIN_VIEWS_DIR',BriefForm_PLUGIN_ADMIN_DIR . '/views');
?>