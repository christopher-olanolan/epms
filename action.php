<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

if(empty($_GET['file'])): 
	include dirname(__FILE__) . "/error.php";
	exit();
else:
	include dirname(__FILE__) . "/loading.php";

	$con = new MySQL();
	$con->connect($config['DB']['LOCAL']['USERNAME'],$config['DB']['LOCAL']['PASSWORD'],$config['DB']['LOCAL']['DATABASE'],$config['DB']['LOCAL']['HOST']);

	switch($action):
		case 'profile':
			$login_id = decryption($ENCRYPT_ID);
			
			$data = array(
				'user_group_id' => $user_group_id,
				'user_email' => $user_email,
				'user_firstname' => $user_firstname,
				'user_lastname' => $user_lastname,
			);

			if (!empty($user_password)):
				$profile = $con->single_result_array("
					SELECT 
						user_password
					FROM epms_user
					WHERE 
						user_id = '$login_id'
				");
				
				$db_user_password = $profile['user_password'];
				$md5_old_password = md5($old_password);
			
				if ($md5_old_password != $db_user_password):
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>Old password mismatch.</span>";
					redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=profile");
					exit();
				elseif ($user_password != $confirm_password):
					$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>Password confirmation mismatch.</span>";
					redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=profile");
					exit();
				else:
					$data['user_password'] = md5($user_password);
					$_SESSION['ENCRYPT_PASSWORD'] = encryption($user_password);
				endif;
			endif;
			
			$update = $con->update($data, epms_user, "user_id = '$login_id'");
			
			$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>Profile successfully updated.</span>";
			redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=profile");
			exit();
			
		break;
		case 'add-user':
			$user_password = md5($user_password);
			
			$data = array(
				'user_name' => $user_name,
				'user_email' => $user_email,
				'user_password' => $user_password,
				'user_group_id' => $user_group_id,
				'user_firstname' => $user_firstname,
				'user_lastname' => $user_lastname
			);
			
			$add = $con->insert($data, epms_user);
			
			$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>User successfully added.</span>";
			redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=manage-user");
			exit();
			
		break;
		case 'edit-user':
			$data = array(
				'user_email' => $user_email,
				'user_group_id' => $user_group_id,
				'user_nickname' => $user_nickname,
				'user_firstname' => $user_firstname,
				'user_lastname' => $user_lastname
			);
			
			if (!empty($user_password)):
				$data['user_password'] = md5($user_password);
			endif;
			
			$update = $con->update($data, epms_user, "user_id = '$user_id'");
			
			$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>User successfully updated.</span>";
			redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=manage-user");
			exit();
			
		break;
		case 'edit-group':
			$module_user_add = $module_user_add == 'on'?1:0;
			$module_user_edit = $module_user_edit == 'on'?1:0;
			$module_user_delete = $module_user_delete == 'on'?1:0;
			
			$module_user_group_add = $module_user_group_add == 'on'?1:0;
			$module_user_group_edit = $module_user_group_edit == 'on'?1:0;
			$module_user_group_delete = $module_user_group_delete == 'on'?1:0;
			
			$module_product_add = $module_product_add == 'on'?1:0;
			$module_product_edit = $module_product_edit == 'on'?1:0;
			$module_product_delete = $module_product_delete == 'on'?1:0;
			
			$data = array(
				'user_group' => $user_group,
				'user_group_controlpanel' => $user_group_controlpanel,
				'module_dashboard' => $module_dashboard,
				'module_user' => $module_user,
				'module_user_add' => $module_user_add,
				'module_user_edit' => $module_user_edit,
				'module_user_delete' => $module_user_delete,
				'module_user_group' => $module_user_group,
				'module_user_group_add' => $module_user_group_add,
				'module_user_group_edit' => $module_user_group_edit,
				'module_user_group_delete' => $module_user_group_delete,
				'module_product' => $module_product,
				'module_product_add' => $module_product_add,
				'module_product_edit' => $module_product_edit,
				'module_product_delete' => $module_product_delete
			);
			
			$update = $con->update($data, epms_user_group, "user_group_id = '$user_group_id'");
			
			$_SESSION['ugid'] = $user_group_id;
			
			$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>User Group successfully updated.</span>";
			redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=manage-group");
			exit();
			
		break;
		case 'delete-group':
			
			$data = array(
				'user_group_status' => $user_group_status
			);
				
			$update = $con->update($data, epms_user_group, "user_group_id = '$user_group_id'");
			
			$_SESSION['ugid'] = $user_group_id;
			
			$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>User Group successfully updated.</span>";
			redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=manage-group");
			exit();
			
		break;
		case 'add-group':
			$module_user_add = $module_user_add == 'on'?1:0;
			$module_user_edit = $module_user_edit == 'on'?1:0;
			$module_user_delete = $module_user_delete == 'on'?1:0;
			
			$module_user_group_add = $module_user_group_add == 'on'?1:0;
			$module_user_group_edit = $module_user_group_edit == 'on'?1:0;
			$module_user_group_delete = $module_user_group_delete == 'on'?1:0;
			
			$module_product_add = $module_product_add == 'on'?1:0;
			$module_product_edit = $module_product_edit == 'on'?1:0;
			$module_product_delete = $module_product_delete == 'on'?1:0;
			
			$data = array(
				'user_group' => $user_group,
				'user_group_controlpanel' => $user_group_controlpanel,
				'module_dashboard' => $module_dashboard,
				'module_user' => $module_user,
				'module_user_add' => $module_user_add,
				'module_user_edit' => $module_user_edit,
				'module_user_delete' => $module_user_delete,
				'module_user_group' => $module_user_group,
				'module_user_group_add' => $module_user_group_add,
				'module_user_group_edit' => $module_user_group_edit,
				'module_user_group_delete' => $module_user_group_delete,
				'module_product' => $module_product,
				'module_product_add' => $module_product_add,
				'module_product_edit' => $module_product_edit,
				'module_product_delete' => $module_product_delete
			);
			
			// printr($_POST);
			
			$add = $con->insert($data, epms_user_group);
			
			$_SESSION['MESSAGE'] = "<span class='pt_8 line_24 wrap'>User Group successfully added.</span>";
			redirect(0,__ROOT__."/index.php?file=cpanel&panel=user&section=manage-group");
			exit();
			
		break;
		default:
			include dirname(__FILE__) . "/error.php";
			exit();
		break;
	endswitch;
endif;
?>