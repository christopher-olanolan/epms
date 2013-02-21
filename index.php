<?
define('__CONTROL__',true);

// SYSTEM INCLUDES
include dirname(__FILE__) . "/system/init.php";
include dirname(__FILE__) . "/system/config.php";
include dirname(__FILE__) . "/system/define.php";
include dirname(__FILE__) . "/system/function.php";
include dirname(__FILE__) . "/system/session.php";
include dirname(__FILE__) . "/system/var.php";
include dirname(__FILE__) . "/ckeditor/ckeditor.php";

// CLASS INCLUDES
include dirname(__FILE__) . "/class/class.mySQL.php";
include dirname(__FILE__) . "/class/class.Query.php";
include dirname(__FILE__) . "/class/class.HTML2Text.php";
include dirname(__FILE__) . "/class/class.SMTP.php";

if(!empty($file)):
	if(file_exists($file.'.php')):
		switch($file):
			case 'login':
			case 'forget':
			case 'process':
			case 'cpanel':
			case 'action':
			case 'ajax':		
				include dirname(__FILE__) .'/'. $file.'.php';
			break;
			default:
				$_GET['file'] = "error";
				$file = $_GET['file'];
				include dirname(__FILE__) .'/'. $file.'.php';
			break;
		endswitch;
		// end file switch
	endif;
	// end file_exists
else:
	$_GET['file'] = "login";
	$file = $_GET['file'];
	include dirname(__FILE__) .'/'. $file.'.php';
endif;
?>
