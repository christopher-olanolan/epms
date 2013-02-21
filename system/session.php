<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

// TIMESTAMP
if (isset($_SESSION['TIMESTAMP']) && (time()-$_SESSION['TIMESTAMP']>__IDLETIME__)):
    unset($_SESSION['ENCRYPT_ID']);
	unset($_SESSION['ENCRYPT_EMAIL']);
	unset($_SESSION['ENCRYPT_PASSWORD']);
	unset($_SESSION['ENCRYPT_LOGIN']);

	$LOGIN_TIMEOUT = false;
else:
	$LOGIN_TIMEOUT = true;
endif;

$_SESSION['TIMESTAMP'] = time();

// MESSAGE
$_SESSION['MESSAGE'] = $MESSAGE;
unset($_SESSION['MESSAGE']);

// LOGIN
if (
	isset($_SESSION['ENCRYPT_ID']) && 
	isset($_SESSION['ENCRYPT_GROUP_ID']) && 
	isset($_SESSION['ENCRYPT_USERNAME']) && 
	isset($_SESSION['ENCRYPT_PASSWORD']) && 
	!empty($ENCRYPT_ID) && 
	!empty($ENCRYPT_GROUP_ID) && 
	!empty($ENCRYPT_USERNAME) && 
	!empty($ENCRYPT_PASSWORD)
):
	$LOGIN_SESSION = true;
else:
	$LOGIN_SESSION = false;
endif;

// SESSION ID
$SESSION_ID = session_id();
?>