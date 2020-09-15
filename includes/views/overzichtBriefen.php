<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type"
	content="text/html";
	charset="UTF-8"/>
	<?php
	if ( function_exists('current_user_can') &&
	!current_user_can('Briefjes_overzicht') )
		die(__('Geen toestemming', 'BriefForm'));

	// Include the Briefje class from the model.
	require_once BriefForm_PLUGIN_MODEL_DIR.'/Briefje.php';
	$Briefje = new Briefje();

	// Get the list with the cards
	$Briefje_lijst = $Briefje->BriefjesSchema();

	// Set timezone default:
	date_default_timezone_set('Europe/Amsterdam');

	?>
</head>
<body>
<h1>Overzicht Briefjes.</h1>
<?php
	echo "<h3>Alle Briefjes</h3><table id='tabel'>
	<th>Briefje ID</th>
	<th>Naam</th>
	<th>Beschrijving</th>";
	foreach ($Briefje_lijst as $Briefje_object){
	echo "<tr><td>".$Briefje_object->getId(); "&nbsp;&nbsp; </td>";
	echo "<td>".$Briefje_object->getBriefjeNaam();"&nbsp;&nbsp; </td>";
	echo "<td>".$Briefje_object->getBeschrijving();"&nbsp;&nbsp; </td></tr>";
	}
	echo "</table>";
?>
</body>
</html>