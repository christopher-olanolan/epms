<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

if(!empty($ajax)):
	if(file_exists(str_replace('//','/',dirname(__FILE__).'/') . 'ajax/'.$ajax.'.php')):
		switch($ajax):
			case 'user':
			case 'product':
				include (str_replace('//','/',dirname(__FILE__).'/') . 'ajax/'.$ajax.'.php');
			break;
			default:
				$_GET['ajax'] = "error";
				$ajax = $_GET['ajax'];
				include (str_replace('//','/',dirname(__FILE__).'/') . 'ajax/'.$ajax.'.php');
			break;
		endswitch;
		// end file
	else:
		$_GET['ajax'] = "error";
		$ajax = $_GET['ajax'];
		include (str_replace('//','/',dirname(__FILE__).'/') . 'ajax/'.$ajax.'.php');
	endif;
	// end file_exists
else:
	$_GET['ajax'] = "error";
	$ajax = $_GET['ajax'];
	include (str_replace('//','/',dirname(__FILE__).'/') . 'ajax/'.$ajax.'.php');
endif;
?>