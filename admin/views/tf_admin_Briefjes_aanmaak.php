<?php
// Include model:
include BriefForm_PLUGIN_MODEL_DIR. "/BriefjeAanmaak.php";
// Declare class variable:
$Briefjes_aanmaak = new BriefjeAanmaak();
// Set base url to current file and add page specific vars
$base_url = get_admin_url().'admin.php';
$params = array( 'page' => basename(__FILE__,".php"));
// Add params to base url
$base_url = add_query_arg( $params, $base_url );
// Get the GET data in filtered array
$get_array = $Briefjes_aanmaak->getGetValues();
 
/*
echo '<pre>';
echo __FILE__.__LINE__.'<br />';
var_dump($get_array);
echo '</pre>';
//*/
 
// Keep track of current action.
$action = FALSE;
if (!empty($get_array)){
 
// Check actions
if (isset($get_array['action'])){
$action = $Briefjes_aanmaak->handleGetAction($get_array);
}
}
// Get the POST data in filtered array
$post_array = $Briefjes_aanmaak->getPostValues();
// Collect Errors
$error = FALSE;
// Check the POST data 
if(!empty($post_array)){
// Check the add form:
$add = FALSE;
if (isset($post_array['add']) ){
 
// Save card
$result = $Briefjes_aanmaak->save($post_array);
if ($result){
// Save was succesfull
$add = TRUE;
} else {
// Indicate error
$error = TRUE;
}
}
// Check the update form:
 if (isset($post_array['update']) ){
 // Save card
 $Briefjes_aanmaak->update($post_array);
 }
}
echo '<pre>';
// echo __FILE__.__LINE__.'<br />';
// var_dump($post_array);
echo '</pre>';
//*/
?>

<div class="wrap">
Admin Briefjes aanmaken CRUD.<br />

<?php
echo ($add ? "<p>Added a new Ticket</p>" : "");
// Check if action == update : then start update form
 echo (($action == 'update') ? '<form action="'.$base_url.'"
method="post">' : '');
?>
<table>
 <caption>Briefjes Aanmaken</caption>
 <thead>
 <tr>
 <th width="10">Id</th>
 <th width="150">Briefje Naam</th>
 <th width="200">Beschrijving</th>
 </tr>
 </thead>

<?php
//*
 if( $Briefjes_aanmaak->getNrOfBriefjesAanmaak() < 1){
?>
 <tr><td colspan="3">Start adding Tickets</tr>
<?php } 
else {
$Briefje_lijst = $Briefjes_aanmaak->getCardList();
}
//** Show all cards in the tabel
foreach( $Briefje_lijst as $Briefje_obj){
// Create update link
$params = array( 'action' => 'update', 'id' => $Briefje_obj->getId());
 
// Add params to base url update link
$upd_link = add_query_arg( $params, $base_url );

// Create delete link
 $params = array( 'action' => 'delete', 'id' => $Briefje_obj->getId());
 // Add params to base url delete link
 $del_link = add_query_arg( $params, $base_url );
?>
<tr>
<td width="10"><?php echo $Briefje_obj->getId(); ?></td>
<?php
 // If update and id match show update form
 // Add hidden field id for id transfer
if ( ($action == 'update') &&
($Briefje_obj->getId() == $get_array['id']) ){
?>
 <td width="180"><input type="hidden" name="id" value="<?php
echo $Briefje_obj->getId(); ?>">
 <input type="text" name="Briefjenaam" value="<?php
echo $Briefje_obj->getBriefjeNaam(); ?>"></td>
 <td width="200"><input type="text" name="beschrijving" value ="<?php
echo $Briefje_obj->getBeschrijving();?>"></td>
 <td colspan="2"><input type="submit" name="update" value="Updaten"
/></td>
 <?php } else { ?>
 <td width="180"><?php echo $Briefje_obj->getBriefjeNaam(); ?></td>
 <td width="200"><?php echo $Briefje_obj->getBeschrijving();?></td>
<?php if ($action !== 'update') {
// If action is update don’t show the action button
?>
 <td><a href="<?php echo $upd_link; ?>">Update</a></td>
 <td><a href="<?php echo $del_link; ?>">Delete</a></td>
<?php
 } // if action !== update
?>

 <?php } // if acton !== update ?> 
</tr>
<?php    
}?>
 </table>
 <?php
 // Check if action = update : then end update form
 echo (($action == 'update' ) ? '</form>' : '');
 
?>
  <form action="<?php echo $base_url; ?>" method="post"><tr>
 <table>
 <tr><td colspan="2"><input type="text" name="Briefjenaam"></td>
<td><input type="text" name="beschrijving"></td></tr>
<tr><td colspan="2"><input type="submit" name="add" value="Toevoegen"/>
</td></tr>
 </table>
 </form> 
</div>