<?php
/**
* Description of Briefje
*
* @author Tom Kuijper
*/
require_once BriefForm_PLUGIN_MODEL_DIR.'/BriefjeAanmaak.php';
class Briefje {
/**
 *
 * @return type array of BriefjeAanmaak
 */
 public function getCardList(){

 return $this->Briefje_aanmaak->getCardList();
 }
  public function BriefjesSchema(){

 return $this->Briefje_aanmaak2->BriefjesSchema();
 }
   public function bestellingSchema(){

 return $this->Briefjes->bestellingSchema();
 }
 /**
 *
 * @var type BriefjeAanmaak
 */
 private $Briefje_aanmaak = null;
 private $Briefje_aanmaak2 = null;
 private $Briefjes = null;

 public function __construct() {

 // Init the card
 $this->Briefje_aanmaak = new BriefjeAanmaak();
 $this->Briefje_aanmaak2 = new BriefjeAanmaak();
 $this->Briefjes = new BriefjeAanmaak();
 }
 
 public function checkNaam($naam){

 if (!is_string($naam)) throw new Exception ( __('Tekst invullen') );

 if (empty($naam)) throw new Exception ( __('Verplicht veld!' ));

 }
 
 public function checkBriefje($Briefje){
 if( !is_numeric($Briefje)) throw new Exception( __('Briefje link incorrect'));

 if( strlen($Briefje) < 1 ) throw new Exception ( __('Verplicht veld!') );

 }

 public function checkEmail($email){

 if (!is_string($email)) throw new Exception ( __('Tekst invullen') );

 if (empty($email)) throw new Exception ( __('Verplicht veld!' ));

 }
 
  public function checkAdres($adres){

 if (!is_string($adres)) throw new Exception ( __('Tekst invullen') );

 if (empty($adres)) throw new Exception ( __('Verplicht veld!' ));

 }
 
  public function checkWoonplaats($woonplaats){

 if (!is_string($woonplaats)) throw new Exception ( __('Tekst invullen') );

 if (empty($woonplaats)) throw new Exception ( __('Verplicht veld!' ));

 }
 
  public function checkPostcode($postcode){

 if (!is_string($postcode)) throw new Exception ( __('Tekst invullen') );

 if (empty($postcode)) throw new Exception ( __('Verplicht veld!' ));

 }

 public function checkDate( $date , $empty = FALSE){

 if ( !$empty && strlen($date) < 1 ) throw new Exception( __('Verplicht
veld') );
 if (!is_string($date)) throw new Exception ( __('Datum tekst formaat
yyyy-mm-dd') );
 // @todo check date format
 }
 
 
 /**
 *
 * @global WPDB $wpdb Wordpress database class
 * @param string $naam
 * @param int $Briefje -> id
 * @param string $email
 * @param string $adres
 * @param string $woonplaats
 * @param string $postcode
 * @param date $datum
 * @return boolean
 */
 function save($naam, $Briefje, $email, $adres, $woonplaats, $postcode, $datum){

 global $wpdb;
 $error = new WP_Error();

 try {
 $this->checkNaam($naam);
 $this->checkBriefje($Briefje);
 $this->checkEmail($email);
 $this->checkAdres($adres);
 $this->checkWoonplaats($woonplaats);
 $this->checkPostcode($postcode);
 $this->checkDate($datum);
 } catch (Exception $exc) {
 $error->add('save', $exc->getMessage());
 }

 // Check on found errors if none save data
 if ( count( $error->get_error_messages() ) < 1 ) {

 $sql = $wpdb->prepare("INSERT INTO `". $wpdb->prefix ."tf_Briefjes`
".
 "( `naam`, `Briefje`, ".
 "`email`, `adres`, `woonplaats`, `postcode`, `datum`)".
 " VALUES ( '%s', '%d', '%s', '%s', '%s', '%s', '%s'".
 ");",
 $naam, $Briefje, $email, $adres, $woonplaats, $postcode, $datum);
 /*
// Check your SQL by adding an additional slash before the ‘/*’
 echo '<pre>';
 var_dump($sql);
 echo '</pre>';
 //*/

 $wpdb->query($sql );

 // Error on save ? It's in there:
 if ( !empty($wpdb->last_error) ){
 $this->last_error = $wpdb->last_error;
 $error->get_error_message($this->last_error);

return $error;
 }

 } else {

 // Some WP_ERROR on input vars
 var_dump($error);
 return $error;
 }

 // Return the last inserted id (Id from the newly created card)
 return $wpdb->insert_id;
 }
 
 
 
}
?>