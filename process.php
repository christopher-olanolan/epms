<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

if(empty($_GET['file']) || empty($_GET['process'])): 
	include dirname(__FILE__) . "/error.php";
	exit();
else:
	include dirname(__FILE__) . "/loading.php";

	// printr($_POST);	
	switch($process):

		// MANAGE USERS
		case 'manage-user':
			$con = new MySQL();
			$con->connect($config['DB']['LOCAL']['USERNAME'],$config['DB']['LOCAL']['PASSWORD'],$config['DB']['LOCAL']['DATABASE'],$config['DB']['LOCAL']['HOST']);
			
			$cbox = count($action['checkbox']);
			
			if (isset($action['single-edit'])):
				$user_id = $action['single-edit'];
				redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=manage-user&action=edit&uid=$user_id");
				exit();

			elseif (isset($action['single-delete'])):
				$user_id = $action['single-delete'];
				$data = array('user_status'=>'2');
				$con->update($data,epms_user,"user_id = '$user_id'");
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>User successfully <strong>deleted</strong>.</span>";
			
			elseif (isset($action['single-active'])):
				$user_id = $action['single-active'];
				$data = array('user_status'=>'1');
				$con->update($data,epms_user,"user_id = '$user_id'");
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>User successfully <strong>activated</strong>.</span>";
					
			elseif ($cbox > 0):
				if ($action['multi-pending'] == 'true'): 
					for($x=0;$x<$cbox;$x++):
						$user_id = $action['checkbox'][$x];
						$data = array('user_status'=>'0');
						$con->update($data,epms_user,"user_id = '$user_id'");
					endfor;
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>$cbox user(s) successfully set to <strong>pending</strong>.</span>";
				
				elseif ($action['multi-active'] == 'true'):
					for($x=0;$x<$cbox;$x++):
						$user_id = $action['checkbox'][$x];
						$data = array('user_status'=>'1');
						$con->update($data,epms_user,"user_id = '$user_id'");
					endfor;
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>$cbox user(s) successfully set to <strong>active</strong>.</span>";
				
				elseif ($action['multi-delete'] == 'true'):
					for($x=0;$x<$cbox;$x++):
						$user_id = $action['checkbox'][$x];
						$data = array('user_status'=>'2');
						$con->update($data,epms_user,"user_id = '$user_id'");
					endfor;
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>$cbox user(s) successfully <strong>deleted</strong>.</span>";
				
				elseif ($action['multi-cancel'] == 'true'): 
					for($x=0;$x<$cbox;$x++):
						$user_id = $action['checkbox'][$x];
						$data = array('user_status'=>'3');
						$con->update($data,epms_user,"user_id = '$user_id'");
					endfor;
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>$cbox user(s) successfully <strong>cancelled</strong>.</span>";

				elseif (isset($action['multi-group'])): 
					for($x=0;$x<$cbox;$x++):
						$user_id = $action['checkbox'][$x];
						$user_group_id = $action['multi']['group_id'];
						$data = array('user_group_id'=>"$user_group_id");
						$con->update($data,epms_user,"user_id = '$user_id'");
					endfor;
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>$cbox user(s) group successfully updated.</span>";
				endif;

			endif;

			redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=manage-user");
			exit();
		break;
		// EOF MANAGE USERS
		
		// MANAGE GROUP
		case 'manage-group':
			$con = new MySQL();
			$con->connect($config['DB']['LOCAL']['USERNAME'],$config['DB']['LOCAL']['PASSWORD'],$config['DB']['LOCAL']['DATABASE'],$config['DB']['LOCAL']['HOST']);
			
			$cbox = count($action['checkbox']);
			
			if (isset($action['single-delete'])):
				$user_group_id = $action['single-delete'];
				$data = array('user_group_status'=>'2');
				$con->update($data,epms_user_group,"user_group_id = '$user_group_id'");
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>User Group successfully <strong>deleted</strong>.</span>";
			
			elseif (isset($action['single-active'])):
				$user_group_id = $action['single-active'];
				$data = array('user_group_status'=>'1');
				$con->update($data,epms_user_group,"user_group_id = '$user_group_id'");
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>User Group successfully <strong>activated</strong>.</span>";	
			
			elseif ($cbox > 0):
				if ($action['multi-pending'] == 'true'): 
					for($x=0;$x<$cbox;$x++):
						$user_group_id = $action['checkbox'][$x];
						$data = array('user_group_status'=>'0');
						$con->update($data,epms_user_group,"user_group_id = '$user_group_id'");
					endfor;
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>$cbox group(s) successfully set to <strong>pending</strong>.</span>";
				
				elseif ($action['multi-active'] == 'true'):
					for($x=0;$x<$cbox;$x++):
						$user_group_id = $action['checkbox'][$x];
						$data = array('user_group_status'=>'1');
						$con->update($data,epms_user_group,"user_group_id = '$user_group_id'");
					endfor;
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>$cbox group(s) successfully set to <strong>active</strong>.</span>";
				
				elseif ($action['multi-delete'] == 'true'):
					for($x=0;$x<$cbox;$x++):
						$user_group_id = $action['checkbox'][$x];
						$data = array('user_group_status'=>'2');
						$con->update($data,epms_user_group,"user_group_id = '$user_group_id'");
					endfor;
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>$cbox group(s) successfully <strong>deleted</strong>.</span>";
				
				elseif ($action['multi-cancel'] == 'true'): 
					for($x=0;$x<$cbox;$x++):
						$user_group_id = $action['checkbox'][$x];
						$data = array('user_group_status'=>'3');
						$con->update($data,epms_user_group,"user_group_id = '$user_group_id'");
					endfor;
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>$cbox group(s) successfully <strong>cancelled</strong>.</span>";
				endif;
			endif;
			
			redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=manage-group");
			exit();
		break;
		// EOF MANAGE GROUP
		
		// RECOVERY
		case 'recovery':
			if(!isset($code) || empty($code) || !isset($userid) || empty($userid)):
				include dirname(__FILE__) . "/error.php";
				exit();
			endif;
			
			$con = new MySQL();
			$con->connect($config['DB']['LOCAL']['USERNAME'],$config['DB']['LOCAL']['PASSWORD'],$config['DB']['LOCAL']['DATABASE'],$config['DB']['LOCAL']['HOST']);
			
			$user_id = decryption($userid);
			$recovery = $con->single_result_array("SELECT * FROM epms_user_recovery WHERE recovery_session_id = '$code' AND user_id = '$user_id'");
			
			if(empty($recovery['user_id']) || $recovery['user_id'] == 'D' || $recovery['user_id'] == ""):
				include dirname(__FILE__) . "/error.php";
				exit();
			endif;
			
			if($recovery['recovery_status'] == '0'):
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap warning'>Password already been activated.</span>";
				redirect(0,__ROOT__."/index.php");
				exit();		
			endif;
			
			$user_password = md5($recovery['recovery_password']);
			$data = array('user_password'=>$user_password);
			$con->update($data, epms_user, "user_id = '$user_id'");
			
			$data = array('recovery_status'=>'0');
			$con->update($data, epms_user_recovery, "user_id = '$userid' AND recovery_session_id = '$code'");
			
			$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>Account password successfully activated.</span>";
			redirect(0,__ROOT__."/index.php");
			exit();		
		break;
		// EOF RECOVERY
		
		// FORGOT PASSWORD
		case 'forgot':
			if(!isset($user_email) || empty($user_email)):
				include dirname(__FILE__) . "/error.php";
				exit();
			endif;
			
			$con = new MySQL();
			$con->connect($config['DB']['LOCAL']['USERNAME'],$config['DB']['LOCAL']['PASSWORD'],$config['DB']['LOCAL']['DATABASE'],$config['DB']['LOCAL']['HOST']);		
			$forgot = $con->single_result_array("SELECT user_id, user_name FROM epms_user WHERE user_email = '$user_email'");
			
			if(empty($forgot['user_id']) || $forgot['user_id'] == 'D' || $forgot['user_id'] == ""):
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>Email address <$user_email> not yet registered.</span>";
				redirect(0,__ROOT__."/index.php?file=forgot");
				exit();
			endif;
			
			$user_id = $forgot['user_id'];
			$recovery_id = encryption($user_id);
			$recovery_user = $forgot['user_name'];
			$recovery_date = date("Y-m-d h:i:s");

			session_regenerate_id();
			$recovery_session_id = session_id();
			$recovery_password = randomPassword();
			$recovery_link = __ROOT__."/index.php?file=process&process=recovery&userid=".$recovery_id."&code=".$recovery_session_id; 
				
			$to = $user_email;
			$from = "drexmod@gmail.com";
			$bcc = $from;
			$subject = "EPMS Control Panel";
			
			$message = "<table cellpadding='0' cellspacing='2' border='0' width='100%'>
			            	<tr height='38'>
			                    <td align='left' colspan='2'>
			                        <strong>$subject</strong>
			                    </td>
			                </tr>
			                <tr height='38'>
			                    <td align='left' colspan='2'>
			                        Here is your account information, which will allow you to log in to EPMS Control Panel:
			                    </td>
			                </tr>
			                <tr>
			                    <td align='left' width='155' style='color:#339900;'><strong>Username:</strong></td>
			                    <td align='left'>$recovery_user</td>
			                </tr>
			                <tr>
			                    <td align='left' style='color:#339900;'><strong>Password:</strong></td>
			                    <td align='left'>$recovery_password</td>
			                </tr>
			                <tr height='60'>
			                    <td align='left' colspan='2'>
			                    	<br />
			                    	To get started, activate your new account password by clicking on the link below and logging in.<br /><br />
			                    	<a href='$recovery_link' style='color:#FF9F00;'><strong><u>$recovery_link</u></strong></a><br />
			                    	If this link doesn't work, please copy and paste it into your browser.
			                    </td>
			                </tr>
            			</table>";
			
			
			$headers  = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			$headers .= "To: <$to>" . "\r\n";
			$headers .= "From: $subject <$from>" . "\r\n";
			$headers .= "Bcc: $bcc" . "\r\n";
			
			mail($to,$subject,$message,$headers);
			
			$data = array(
						'user_id'=>$user_id,
						'recovery_password'=>$recovery_password,
						'recovery_session_id'=>$recovery_session_id,
						'recovery_date'=>$recovery_date,
						'recovery_link'=>$recovery_link,
						'recovery_status'=> 1
					);
					
			$con->insert($data, epms_user_recovery);
					
			$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>Please check your email to activate your new account password.</span>";
			redirect(0,__ROOT__."/index.php");
			exit();
		break;
		// FORGOT PASSWORD
			
		// LOGOUT
		case 'logout':
			unset($_SESSION['ENCRYPT_ID']);
			unset($_SESSION['ENCRYPT_USERNAME']);
			unset($_SESSION['ENCRYPT_PASSWORD']);
			unset($_SESSION['ENCRYPT_LOGIN']);
			
			$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>You are now logged off.</span>";
			redirect(0,__ROOT__."/index.php");
			exit();
		break;
		// EOF LOGOUT
		
		// LOGIN
		case 'login':
			if (empty($user_name) || empty($user_password) || !isset($user_name) || !isset($user_password)):
				$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>Invalid login details. Please enter a valid login access</span>";
				redirect(0,__ROOT__."/index.php");
				exit();
			else:
				$con = new MySQL();
				$con->connect($config['DB']['LOCAL']['USERNAME'],$config['DB']['LOCAL']['PASSWORD'],$config['DB']['LOCAL']['DATABASE'],$config['DB']['LOCAL']['HOST']);
			
				$user_name = htmlentities($user_name, ENT_QUOTES);
				$md5password = md5($user_password);
				
				$check_access = $con->single_result_array("
					SELECT 
						t1.user_id,
						t1.user_login,
						t1.user_group_id,
						t1.user_status,
						t2.user_group_controlpanel,
						t2.user_group_status
					FROM epms_user AS t1 
						LEFT JOIN epms_user_group AS t2 ON t1.user_group_id = t2.user_group_id 
					WHERE 
						t1.user_name = '$user_name' AND 
						t1.user_password = '$md5password'
				");
				
				// printr($check_access);
				// exit();
				
				if ($check_access['user_id'] == 'D' || empty($check_access['user_id'])):
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>Invalid login details. Please enter a valid login access</span>";
					redirect(0,__ROOT__."/index.php?file=login");
					exit();
				elseif($check_access['user_status']!='1'):
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24'>Your account is disabled. Please contact administrator</span>";
					redirect(0,__ROOT__."/index.php?file=login");
					exit();
				elseif($check_access['user_group_controlpanel']=='0'):
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24'>Your user group don't have permission to access the link/file on this server.</span>";
					redirect(0,__ROOT__."/index.php?file=login");
					exit();
				elseif($check_access['user_group_status']!='1'):
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24'>Your user group is not active.</span>";
					redirect(0,__ROOT__."/index.php?file=login");
					exit();
				else:
					$user_id = $check_access['user_id'];
					$user_login = $check_access['user_login']+1;
					$user_group_id = $check_access['user_group_id'];
					$user_session_id = $SESSION_ID;
					$user_last_login = date("Y-m-d h:i:s");

					$data = array(
						'user_last_login'=>$user_last_login,
						'user_login'=>$user_login,
						'user_session_id'=>$user_session_id
					);
					
					$con->update($data, epms_user, "user_id = '$user_id'");
					
					$data = array(
						'user_id'=>$user_id,
						'log_date'=>$user_last_login,
						'log_module'=>'controlpanel',
						'log_action'=>'login'
					);
					
					$con->insert($data, epms_user_log);
					
					$_SESSION['ENCRYPT_ID'] = encryption($user_id);
					$_SESSION['ENCRYPT_GROUP_ID'] = encryption($user_group_id);
					$_SESSION['ENCRYPT_USERNAME'] = encryption($user_name);
					$_SESSION['ENCRYPT_PASSWORD'] = encryption($user_password);
	
					redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=profile");
					exit();
				endif;
			endif;
		break;
		// EOF LOGIN
		
		default:
			include dirname(__FILE__) . "/error.php";
			exit();
		break;
	endswitch;
endif;
?>