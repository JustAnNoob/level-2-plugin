<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type"
	content="text/html";
	charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style>
		<?php include 'style.css'; ?>
	</style>
	<?php
	if ( function_exists('current_user_can') &&
	!current_user_can('bestelling_overzicht') )
		die(__('Geen toestemming', 'BriefForm'));

	// Include the Briefje class from the model.
	require_once BriefForm_PLUGIN_MODEL_DIR.'/Briefje.php';
	$Briefje = new Briefje();
	$Briefje2 = new Briefje();

	// Get the list BriefjesSchema
	$Briefje_lijst = $Briefje->BriefjesSchema();
	
	
	// Get the list bestellingSchema
	$Briefje_lijst2 = $Briefje2->bestellingSchema();

	// Set timezone default:
	date_default_timezone_set('Europe/Amsterdam');

	?>
</head>
<body>
<h1>Overzicht briefjes</h1>
<?php
	echo "<table id='tabel'>
			<th>ID(DB)</th>
			<th>Naam</th>
			<th>Briefje ID</th>
			<th>Email</th>
			<th>Adres</th>
			<th>Woonplaats</th>
			<th>Postcode</th>
			<th>Datum</th>";
	foreach ($Briefje_lijst2 as $Briefje_object2){
	echo "<tr><td>".$Briefje_object2->getId(); "&nbsp;&nbsp; </td>";
	echo "<td>".$Briefje_object2->getNaam();"&nbsp;&nbsp; </td>";
	echo "<td>".$Briefje_object2->getBriefjeId();"&nbsp;&nbsp; </td>";
	echo "<td>".$Briefje_object2->getEmail();"&nbsp;&nbsp; </td>";
	echo "<td>".$Briefje_object2->getAdres();"&nbsp;&nbsp; </td>";
	echo "<td>".$Briefje_object2->getWoonplaats();"&nbsp;&nbsp; </td>";
	echo "<td>".$Briefje_object2->getPostcode();"&nbsp;&nbsp; </td>";
	echo "<td>".$Briefje_object2->getDatum();"&nbsp;&nbsp; </td></tr>";
	}
	echo "</table>";
?>
</body>
</html>