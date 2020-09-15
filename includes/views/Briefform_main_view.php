<?php
// Set base url and add page specific vars
$base_url = get_permalink();

// Include the Briefje class from the VIEW.
require_once BriefForm_PLUGIN_INCLUDES_VIEWS_DIR.'/View.php';

$Briefjes_view = new BriefjesView();

// Get the getters
$get_inputs = $Briefjes_view->getGetValues();

// Get form vars
$post_inputs = $Briefjes_view->getPostValues();

// If provided set current file based on the provided link
$current_file = (!empty($get_inputs['link']) ?
BriefForm_PLUGIN_INCLUDES_VIEWS_DIR. '/'. $get_inputs['link'].'.php' :
'');
// Add the current page link get param.
if (!empty($get_inputs['link'])){
 $params = array( 'link' => $get_inputs['link']);
 $file_base_url = add_query_arg( $params, $base_url );

} else {
 // Or stick to base url
 $file_base_url = $base_url;
}

$form_result = new WP_Error();

// Check add form Briefje :
if ( $Briefjes_view->is_submit_add_form($post_inputs) ){
	
 // Check add form submission :
 $form_result = $Briefjes_view->check_save_form( $post_inputs );

 if ( !is_bool($form_result) && get_class($form_result) == 'WP_Error'){

 // Reshow the form again.
 } else{

 echo "Het is opgeslagen in de database!!!!!!!<br />";

 // Check on error
 if ( !($form_result instanceof WP_Error )){

 $form_result = new WP_Error();
 }

 // Create instance of Briefje class
 $Briefje = new Briefje();

 // Save the card
 $return = $Briefje->save($post_inputs['naam'],
 $post_inputs['Briefje'],
 $post_inputs['email'],
 $post_inputs['adres'],
 $post_inputs['woonplaats'],
 $post_inputs['postcode'],
 $post_inputs['datum']);

 if ( ! ($return instanceof WP_Error)) {
 // Do not show the Briefje input file again : Show main page
 $current_file = '';
 }
 
 }
}

if (!empty($current_file) && file_exists( $current_file)){

 // Include the link file and show that page.
 include $current_file;
 } //*
else if (!empty($current_file) && !file_exists($current_file)){
 // Linked file not found!
 // @todo: Change error
 echo '<span style="color:red">Main view error: FILE NOT FOUND ['.
$current_file .']</span>';

} //*/
else {

echo '<span style="font-size:22px;color:blue">Main View</span><br>';
?>
<br>
<?php
//if (current_user_can( 'Briefjes_lezen' ) ){
	//if (current_user_can('Briefjes_bestellen')){
 // Create add link
 $params = array( 'link' => 'Briefje_bestellen');
 // Add params to base url update link
 $link = add_query_arg( $params, $base_url );
?>
<a id='button' href="<?php echo $link;?>">Briefje bestellen </a><p />

<?php
//}
if (current_user_can('bestelling_overzicht')){
 // Create list link
 $params = array( 'link' => 'bestellingen_lijst');
 // Add params to base url link
 $link = add_query_arg( $params, $base_url );
?>
<a id='button' href="<?php echo $link;?>">Bestellings lijst </a><br>

<?php
}
if (current_user_can('Briefjes_overzicht')){
 // Create list link
 $params = array( 'link' => 'overzichtBriefen');
 // Add params to base url link
 $link = add_query_arg( $params, $base_url );
?>
<a id='button' href="<?php echo $link;?>">Briefjes overzicht </a><br>
<?php
    //}
}	// current_user_can()
}
?>
<br>