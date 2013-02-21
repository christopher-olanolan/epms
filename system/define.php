<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

extract($_COOKIE);
extract($_ENV);
extract($_FILES);
extract($_GET);
extract($_POST);
extract($_REQUEST);
extract($_SESSION);
extract($_SERVER);

$_HOST = explode("/",$SERVER_NAME.$SCRIPT_NAME);
$_PROTOCOL = "http://"; 
$_PORT = ":80";
$s = sizeof($_HOST)-1;
// $_ROOT = str_replace("/".$_HOST[$s], "", $_PROTOCOL.$SERVER_NAME.$_PORT.$SCRIPT_NAME);
$_ROOT = str_replace("/".$_HOST[$s], "", $_PROTOCOL.$SERVER_NAME.$SCRIPT_NAME);

// NAMES
define("__TITLE__", 'UNILAB Backoffice');

// URI
define("__ROOT__", $_ROOT);
define("__HOME__", __ROOT__ . '/?file=main');
define("__LOGIN__", __ROOT__ . '/?file=login');
define("__ERROR__", __ROOT__ . '/?file=error');

// FILES
define("__SCRIPT__", __ROOT__ . "/scripts/");
define("__STYLE__", __ROOT__ . "/styles/");
define("__IMAGE__", __ROOT__ . "/images/");

// LOGIN
define("__IDLETIME__", '3600'); // 1 hour
define("__ACCESS__", false);

// QUERY DEFAULT
define("__LIMIT__", '5');
?>
