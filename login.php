<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

if(empty($_GET['file'])): 
	include dirname(__FILE__) . "/error.php";
	exit();
endif;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=__TITLE__?> | <?=$file?></title>

<link type="image/x-icon" href="<?=__ROOT__?>/favicon.ico" rel="shortcut icon">
<link rel="stylesheet" type="text/css" href="<?=__STYLE__?>style.css" >
<link rel="stylesheet" type="text/css" href="<?=__STYLE__?>button.css">
<link rel="stylesheet" type="text/css" href="<?=__STYLE__?>form.css">

<script type="text/javascript" src="<?=__SCRIPT__?>jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?=__SCRIPT__?>jquery.metadata.js"></script>
<script type="text/javascript" src="<?=__SCRIPT__?>jquery.mockjax.js"></script>
<script type="text/javascript" src="<?=__SCRIPT__?>jquery.form.js"></script>
<script type="text/javascript" src="<?=__SCRIPT__?>jquery.validate.js"></script>
<script type="text/javascript" src="<?=__SCRIPT__?>jquery.countdown.js"></script>
<script type="text/javascript" src="<?=__SCRIPT__?>script.js"></script>

<script type="text/javascript">
	var wait = 10;
	function doCountdown(){
		var timer = setTimeout(function(){
			wait--;
			if(wait > 0){
				doCountdown(); 
			} else {
				$('#message').addClass('hidden');
			};
		},1000);
	};
	
$(function() {
	<? 
	if ($MESSAGE != ""):
		echo "doCountdown();";
	endif;
	?>
		
	$("input.login_inputtext").val('');
	
	$("input.login_inputtext")
	.bind('keyup',function(event) {
		if($(this).val() != ""){
			$(this).prev().addClass("hidden");
		} else {
			$(this).prev().removeClass("hidden");
		}
	})
	.bind('change',function(event) {
		if($(this).val() != ""){
			$(this).prev().addClass("hidden");
		} else {
			$(this).prev().removeClass("hidden");
		}
	})
	.bind('blur',function(event) {
		if($(this).val() != ""){
			$(this).prev().addClass("hidden");
		} else {
			$(this).prev().removeClass("hidden");
		}
	})
	.bind('focus',function(event) {
		if($(this).val() != ""){
			$(this).prev().addClass("hidden");
		} else {
			$(this).prev().removeClass("hidden");
		}	
	});
	
	$(".placeholder").click(function(){
		$(this).next().focus();
	});
	
	$("#loginForm").validate({
		rules: {
			user_name : {
				required: true
			},	
			user_password : {
				required: true
			}
		},
		messages: {
			user_name : {
				required: "Please enter your user name.",
			},	
			user_password : {
				required: "Please provide a password."
			}
		},
		onkeyup: false,
  		onblur: true
	});
});
</script>
</head>
<body>
<div style="width:100%;" align="center">
	<div class="top gradient clean">
    	<div style="width:98%;" align="left">
    		<div class="title4 float_left"><?=__TITLE__?></div>
        	<div align="left" class="line_40 shadow float_right">
                <div class="line_40 shadow pt_8" align="right"><span class="wrap" id="UTCDate"></span></div>
            </div>
        </div>
    </div>

	<div style="width:100%;" align="center">
    	<div class="spacer_40 clean"><!-- SPACER --></div>
        <div style="width:100%; height:10px;"> 
        	<div style="width:100%" align="center" id="message"><?=$MESSAGE?></div>
        </div>
        <div class="spacer_40 clean"><!-- SPACER --></div>
    </div>

	<div class="spacer_20 clean"><!-- SPACER --></div>
    <form id="loginForm" action="<?=__ROOT__?>/index.php?file=process&process=login" method="post">
            
    <!-- LOGIN -->	
    <div class="box-login radius_5 gradient shadow pt_8" style="width:290px">
        <div style="width:97%;">
            <table cellpadding="0" cellspacing="10" border="0" width="100%">
                <tr height="38">
                    <td align="left" style="position:absolute; width:255px;">
                        <span class="placeholder pt_8 opacity">Enter your username</span>
                        <input id="user_name" name="user_name" type="text" class="login_inputtext" maxlength="50" />
                        <label for="user_name" generated="false" class="error placeerror"></label>
                    </td>
                </tr>
                <tr height="38">
                   <td align="left" style="position:absolute; width:255px;">
                        <span class="placeholder pt_8 opacity">Password</span>
                        <input id="user_password" name="user_password" type="password" class="login_inputtext" maxlength="50" />
                        <label for="user_password" generated="false" class="error placeerror"></label>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="pt_8 shadow">
                        <span class="line_13"><a href="<?=__ROOT__?>/?file=forget">Forgot password?</a></span>
                    </td>
                </tr>
                <tr height="38">
                    <td align="center" valign="bottom">
                        <input name="login" type="submit" value="Login" class="button default_button" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="spacer_5 clean"><!-- SPACER --></div>
    </div>
    
    </form>
    
    <div class="spacer_10 clean"><!-- SPACER --></div>
    <span class="pt_8 white footer">EPMS - <?=date(Y)?> All Rights Reserved</span>
</div>
</body>
</html>