<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

// printr($_SESSION);

if(empty($_GET['file'])): 
	include dirname(__FILE__) . "/error.php";
	exit();
else:
	if ($LOGIN_TIMEOUT == false):
		$_SESSION['MESSAGE'] = "<span class='pt_8 line_24'>No activity for 1 hour; please log in again.</span>";
		redirect(0,__ROOT__."/index.php?file=login");
		exit();
	else:
		if ($LOGIN_SESSION == true):
			$con = new MySQL();
			$con->connect($config['DB']['LOCAL']['USERNAME'],$config['DB']['LOCAL']['PASSWORD'],$config['DB']['LOCAL']['DATABASE'],$config['DB']['LOCAL']['HOST']);
		
			$login_id = decryption($ENCRYPT_ID);
			$login_username = decryption($ENCRYPT_USERNAME);
			$login_password = decryption($ENCRYPT_PASSWORD);
			$login_md5password = md5($login_password);
			$login_group_id = decryption($ENCRYPT_GROUP_ID);
			$login_session_id = $SESSION_ID;
			
			$user_access = $con->single_result_array("
				SELECT 
					t1.user_id,
					t1.user_firstname,
					t1.user_lastname,
					t2.*
				FROM epms_user AS t1 
					LEFT JOIN epms_user_group AS t2 ON t1.user_group_id = t2.user_group_id 
				WHERE 
					t1.user_id = '$login_id' AND 
					t1.user_name = '$login_username' AND 
					t1.user_password = '$login_md5password' AND 
					t1.user_group_id = '$login_group_id' AND
					t1.user_session_id = '$login_session_id' AND
					t1.user_status = '1'
			");
			
			
			// printr($user_access);
			// exit();
			if ($user_access['user_id'] == 'D' || empty($user_access['user_id'])):
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24'>You don't have permission to access the link/file on this server.</span>";
				redirect(0,__ROOT__."/index.php?file=login");
				exit();
			elseif($user_access['user_group_controlpanel']=='0'):
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24'>Your user group don't have permission to access the link/file on this server.</span>";
				redirect(0,__ROOT__."/index.php?file=login");
				exit();
			elseif($user_access['user_group_status']!='1'):
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24'>Your user group is not active.</span>";
				redirect(0,__ROOT__."/index.php?file=login");
				exit();
			else:
				define("__ACCESS__", true);
				$login_firstname = $user_access['user_firstname'];
				$login_lastname = $user_access['user_lastname'];
				
				if ($login_firstname != ''):
					$lastname = $login_lastname != '' ? ' '.$login_lastname:'';
					$login_name = $login_firstname.$lastname;
				else:
					$login_name = $login_username;
				endif;
			?>
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="https://www.w3.org/1999/xhtml">
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title><?=__TITLE__?> | <?=$file?></title>
					<? include dirname(__FILE__) . "/scripts.php"; ?>
				</head>
				
				<body>
				<div style="width:100%;" align="center">
					<!-- HEADER -->
					<div class="top gradient clean">
				    	<div style="width:98%;" align="left">
				    		<div class="title4 float_left"><?=__TITLE__?></div>
				        	<div align="left" class="line_40 shadow float_right">
				        		<div style="float:right; padding-left:10px;" class="line_40 shadow pt_8"><span class="wrap" id="UTCDate"></span></div>
								<div style="float:right; padding-top:9px; padding-left:5px;"><a href="<?=__ROOT__?>/index.php?file=process&process=logout" class="clean unselectable"><span class="ico ico_logout block clean">&nbsp;</span></a></div>
								<div style="float:right;" class="pt_8 gray">Welcome: <span class="wrap pt_8"><strong><a href="<?=__ROOT__?>/?file=cpanel&panel=user&section=profile"><?=$login_name?></a></strong></span></div>
				            </div>
				        </div>
				    </div>
					<!-- EOF HEADER -->
					
					<div class="spacer_20 clean"><!-- SPACER --></div>
                    <div style="width:100%; height:10px;"> 
                    	<div style="width:100%" align="center" id="message"><?=$MESSAGE?></div>
                    </div>
                    <div class="spacer_30 clean"><!-- SPACER --></div>
                    
					<div style="width:100%; display:block;" align="left">
						<div style="width:98%; padding-left:10px;">
							
							<? include dirname(__FILE__) . "/menu.php"; ?>
							
							<!-- CONTENT -->
							<div style="width:84%;" class="float_left block" align="center">
								<div style="width:100%; padding-left:5px;">
									<div class="box radius_5 gradient shadow pt_8" style="width:100%;">
										<div style="padding:5px;">
											<div class="radius_5 solid shadow gradient-inner">
												<div class="clean unselectable title">
													<div style="text-transform:capitalize; float:left; width:20%; padding-bottom:10px;" class="pad_left_10 line_35">
														<span class="ico ico_<?=$panel?> clean block float_left"></span> 
														<span class="float_left pad_left_5" style="color:#555555;"><strong><?=$panel?></strong></span>
													</div>
													<div style="float:right; width:70%; padding-right:4px;" align="right">
														<? /*
														<a class="tab tab_radius gradient-inner">Edit</a>
														<a class="tab tab_radius gradient-inner">Add</a>
														<a class="tab tab_radius gradient-inner">Delete</a>
														*/ ?>
													</div>
												</div>
												
												<div style="padding:5px; min-height:282px; margin-right:5px;" class="clean gray">
													<div id="loadpage" align="center">
														<div class="spacer_100 clean"><!-- SPACER --></div>
														<img src="<?=__IMAGE__?>load.gif" class="clean" />
														<div class="spacer_5 clean"><!-- SPACER --></div>
														<span class="shadow pt_8">loading...</span>
													</div>
							
													<div id="contents" class="hidden">
														<?
														if(!empty($panel)):
															if(file_exists(str_replace('//','/',dirname(__FILE__).'/') . 'controlpanel/'.$panel.'.php')):
																switch($panel):
																	case 'user':
																	case 'product':
																		include (str_replace('//','/',dirname(__FILE__).'/') . 'controlpanel/'.$panel.'.php');
																	break;
																	default:
																		$_GET['panel'] = "error";
																		$panel = $_GET['panel'];
																		include (str_replace('//','/',dirname(__FILE__).'/') . 'controlpanel/'.$panel.'.php');
																	break;
																endswitch;
																// end file
															else:
																$_GET['panel'] = "error";
																$panel = $_GET['panel'];
																include (str_replace('//','/',dirname(__FILE__).'/') . 'controlpanel/'.$panel.'.php');
															endif;
															// end file_exists
														else:
															$_GET['panel'] = "dashboard";
															$panel = $_GET['panel'];
															include (str_replace('//','/',dirname(__FILE__).'/') . 'controlpanel/'.$panel.'.php');
														endif;
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="spacer_20 clean"><!-- SPACER --></div>
								<span class="pt_8 white footer">EPMS - <?=date(Y)?> All Rights Reserved</span>
							</div>
							<!-- EOF CONTENT -->
						</div>
						<div class="spacer_20 clean clear"><!-- SPACER --></div>
					</div>
				</div>
				<img src="<?=__IMAGE__?>blank.gif" class="clean hidden" onload="fileLoaded();" />
				</body>
				</html>
			<?
			endif;
		else:
			include dirname(__FILE__) . "/error.php";
			exit();
		endif;
	endif;
endif;
?>