<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

$config = array(
	// DATABASE CONFIGURATION
	"DB" => array(
		"LOCAL" => array( 
			// LOCAL
			"HOST" => "localhost",
			"USERNAME" => "geeks_epms",
			"PASSWORD" => "epms_geeks",
			"DATABASE" => "geeks_epms",	
		),
		"REMOTE" => array(	
			// REMOTE
			"HOST" => "localhost",
			"USERNAME" => "geeks_epms",
			"PASSWORD" => "epms_geeks",
			"DATABASE" => "geeks_epms"
		)
	)
);

$apps = array(
	// FACEBOOK
	"_FACEBOOK_APP_ID" => "",
	"_FACEBOOK_SECRET" => ""
);

$file = array(

);
?>