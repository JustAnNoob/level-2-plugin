<?php

// function to create the DB / Options / Defaults					
function install_tables() {
	
   	global $wpdb;
  	global $tblname;
	$tblname = $wpdb->prefix . 'tf_Briefjes';
	$tblname1 = $wpdb->prefix . 'tf_Briefjes_aanmaak';
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$tblname'") != $tblname) 
	{
		$sql = "CREATE TABLE " . $tblname . " (
		`id_Brief` bigint(10) NOT NULL AUTO_INCREMENT,
		`naam` varchar(64) NOT NULL,
		`Briefje` bigint(10) NOT NULL,
		`email` varchar(64) NOT NULL,
		`adres` varchar(64) NOT NULL,
		`woonplaats` varchar(64) NOT NULL,
		`postcode` varchar(11) NULL,
		`datum` date NULL,
		PRIMARY KEY id_Brief (id_Brief)
		);";
		
		$sql1 = "CREATE TABLE " . $tblname1 . " (
		`id_Briefje` bigint(10) NOT NULL AUTO_INCREMENT,
		`Briefjenaam` varchar(32) NOT NULL,
		`beschrijving` varchar(1024) NOT NULL,
		PRIMARY KEY id_Briefje (id_Briefje),
		UNIQUE KEY Briefjenaam (Briefjenaam)
		);";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		dbDelta($sql1);
	}
 
}

?>