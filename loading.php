<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

if(empty($_GET['file'])): 
	include dirname(__FILE__) . "/error.php";
	exit();
else:
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="https://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=__TITLE__?> | <?=$file?></title>
		
	<link type="image/x-icon" href="favicon.ico" rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	
	<script type="text/javascript" src="scripts/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="scripts/script.js"></script>
	</head>
	<body>
	<div style="width:100%;" align="center">
		<div class="top gradient clean">
	    	<div style="width:98%;" align="left">
	    		<div class="title4 float_left"><?=__TITLE__?></div>
	        	<div align="left" class="line_40 shadow">
	                <div style="float:right;" class="line_40 shadow pt_8" align="right"><span class="wrap" id="UTCDate"></span></div>
	            </div>
	        </div>
	    </div>
		
		<div class="spacer_40 clean"><!-- SPACER --></div>
		
		<div class="box radius_5 gradient shadow pt_8" style="width:256px;">
			<div style="padding:5px;">
				<div class="radius_5 solid shadow gradient-inner">
					<div class="spacer_10 clean"><!-- SPACER --></div>
					<img src="images/load.gif" class="clean" />
					<div class="spacer_8 clean"><!-- SPACER --></div>
					<span class="wrap shadow pt_8">loading...</span>
					<div class="spacer_15 clean"><!-- SPACER --></div>
				</div>
			</div>
		</div>
	</div>
	</body>
	</html>
<?
endif;
?>