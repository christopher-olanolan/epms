<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

if(empty($_GET['panel']) || empty($_GET['section'])): 
	include dirname(__FILE__) . "/error.php";
else:
	switch($section):
		case 'profile':
			$profile = $con->single_result_array("SELECT * FROM epms_user WHERE user_id = '$login_id'");
			
			$user_email = $profile['user_email'];
			$user_firstname = $profile['user_firstname'];
			$user_lastname = $profile['user_lastname'];

			$superuser = $login_group_id == '1'? '':'AND user_group_id != "1"';
			$select = new Select();
			$select_user_group =  $select->option_query(
						'epms_user_group', 							// table name
						'user_group_id',  							// name='$name' 
						'user_group_id', 							// id='$id'
						'user_group_id',							// value='$value'
						'user_group',								// option name
						$login_group_id,							// default selected value
						'user_group_status = "1" '.$superuser,		// query condition(s)    
						'user_group',								// 'order by' field name
						'ASC',										// sort order 'asc' or 'desc'
						'selectoption default_select',				// css class
						'Choose Group',								// default null option name 'Choose option...'	
						'0'											// select type 1 = multiple or 0 = single
					);
					
			// printr($profile);

		?>
        	<form method="post" enctype="multipart/form-data" action="<?=__ROOT__?>/index.php?file=action&action=profile" id="profileForm">
        	<div style="width:100%;" align="left" class="shadow gray">
            	<div class="spacer_3 clean"><!-- SPACER --></div>
            	<strong>General Information:</strong>
                <div class="spacer_5 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_0 clean"><!-- SPACER --></div>
                
                <table width="500" border="0" cellpadding="0" cellspacing="5">
                	<tr>
                    	<td width="220">Username: </td>
                        <td class="line_30"><?=$login_username?></td>
                    </tr>
                    <tr>
                    	<td>Email: </td>
                        <td><input id="user_email" name="user_email" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$user_email?>" /></td>
                    </tr>
                    <tr>
                    	<td>Old Password: </td>
                        <td><input id="old_password" name="old_password" type="password" class="inputtext default_inputtext" maxlength="50" value="" /></td>
                    </tr>
                    <tr>
                    	<td>New Password: </td>
                        <td><input id="user_password" name="user_password" type="password" class="inputtext default_inputtext" maxlength="50" value="" /></td>
                    </tr>
                    <tr>
                    	<td>Confirm New Password: </td>
                        <td><input id="confirm_password" name="confirm_password" type="password" class="inputtext default_inputtext" maxlength="50" value="" /></td>
                    </tr>
                    <tr>
                    	<td>User Group: </td>
                        <td><?=$select_user_group?></td>
                    </tr>
                </table>
                
                <div class="spacer_10 clean"><!-- SPACER --></div>
                <strong>Personal Information:</strong>
                <div class="spacer_5 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_0 clean"><!-- SPACER --></div>
                
                <table width="500" border="0" cellpadding="0" cellspacing="5">
                    <tr>
                    	<td width="220">Firstname: </td>
                        <td><input id="user_firstname" name="user_firstname" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$user_firstname?>" /></td>
                    </tr>
                    <tr>
                    	<td>Lastname: </td>
                        <td><input id="user_lastname" name="user_lastname" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$user_lastname?>" /></td>
                    </tr>
                </table>

                <div class="spacer_40 clean"><!-- SPACER --></div>
                
                <div style="width:100%;" align="left">
                <input name="clear" type="reset" value="Reset Form" class="button" />
                <input name="update" type="submit" value="Update" class="button" />
                </div>
            </div>
            </form>
            
            <script>
            $(document).ready(function() {
            	$("#profileForm").validate({
					rules: {
						user_email : {
							required: true,
							email: true,
							remote: "<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=useremail&id=<?=$profile['user_id']?>"
						},
						old_password : {
							required: false,
							remote: "<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=old-password&id=<?=$profile['user_id']?>"
						},
						confirm_password : {
							required: false,
							equalTo: "#user_password"
						},
						user_password : {
							required: false
						},
						user_group_id: {
							required: true,
							notEqual: 0
						}
					},
					messages: {
						user_email : {
							required: "Please provide your email address",
							email: "Please provide a valid email address",
							remote: "Email already registered." 
						},
						old_password : {
							remote: "Please provide the correct password."
						},
						confirm_password : {
							equalTo: "Password did not match."
						},
						user_group_id: {
							notEqual: "Please select a user group."
						}
					},
					onkeyup: false,
			  		onblur: true
				});
			});
            </script>
        <?
		break;
		case 'add-user':
			$select = new Select();
			$select_user_group =  $select->option_query(
						'epms_user_group', 				// table name
						'user_group_id',  				// name='$name' 
						'user_group_id', 				// id='$id'
						'user_group_id',				// value='$value'
						'user_group',					// option name
						'',								// default selected value
						'user_group_status = "1"  
						AND user_group_id != "1"',		// query condition(s)  
						'user_group',					// 'order by' field name
						'ASC',							// sort order 'asc' or 'desc'
						'selectoption default_select',	// css class
						'Choose Group',					// default null option name 'Choose option...'	
						'0'								// select type 1 = multiple or 0 = single
					);
		?>
        	<form method="post" enctype="multipart/form-data" action="<?=__ROOT__?>/index.php?file=action&action=add-user" id="adduserForm">
        	<div style="width:100%;" align="left" class="shadow gray">
            	<div class="spacer_3 clean"><!-- SPACER --></div>
            	<strong>General Information:</strong>
                <div class="spacer_5 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_0 clean"><!-- SPACER --></div>

                <table width="500" border="0" cellpadding="0" cellspacing="5">
                	<tr>
                    	<td width="220">Username: </td>
                        <td><input id="user_name" name="user_name" type="text" class="inputtext default_inputtext" maxlength="50" value="" /></td>
                    </tr>
                    <tr>
                    	<td>Email: </td>
                        <td><input id="user_email" name="user_email" type="text" class="inputtext default_inputtext" maxlength="50" value="" /></td>
                    </tr>
                    <tr>
                    	<td>Password: </td>
                        <td><input id="user_password" name="user_password" type="password" class="inputtext default_inputtext" maxlength="50" value="" /></td>
                    </tr>
                    <tr>
                    	<td>Confirm Password: </td>
                        <td><input id="confirm_password" name="confirm_password" type="password" class="inputtext default_inputtext" maxlength="50" value="" /></td>
                    </tr>
                    <tr>
                    	<td>User Group: </td>
                        <td><?=$select_user_group?></td>
                    </tr>
                </table>
                
                <div class="spacer_10 clean"><!-- SPACER --></div>
                <strong>Personal Information:</strong>
                <div class="spacer_5 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_0 clean"><!-- SPACER --></div>
                
                <table width="500" border="0" cellpadding="0" cellspacing="5">
                    <tr>
                    	<td width="220">Firstname: </td>
                        <td><input id="user_firstname" name="user_firstname" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$user_firstname?>" /></td>
                    </tr>
                    <tr>
                    	<td>Lastname: </td>
                        <td><input id="user_lastname" name="user_lastname" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$user_lastname?>" /></td>
                    </tr>
                </table>

                <div class="spacer_40 clean"><!-- SPACER --></div>
                
                <div style="width:100%;" align="left">
                <input name="clear" type="reset" value="Reset Form" class="button" />
                <input name="update" type="submit" value="Add User" class="button" />
                </div>
            </div>
            </form>
            
            <script>
            $(document).ready(function() {
            	$("#adduserForm").validate({
					rules: {
						user_name : {
							required: true,
							remote: "<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=username"
						},
						user_email : {
							required: true,
							email: true,
							remote: "<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=email" 
							
						},
						user_password : {
							required: true
						},
						confirm_password : {
							required: true,
							equalTo: "#user_password"
						},
						user_group_id: {
							required: true,
							notEqual: 0
						}
					},
					messages: {
						user_name : {
							required: "Please provide a username.",
							remote: "Username not available."
						},
						user_email : {
							required: "Please provide your email address.",
							email: "Please provide a valid email address.",
							remote: "Email already registered." 
							
						},
						user_password : {
							required: "Please provide your password"
						},
						confirm_password : {
							required: "Please retype your password",
							equalTo: "Password did not match."
						},
						user_group_id: {
							notEqual: "Please select a user group."
						}
					},
					onkeyup: false,
			  		onblur: true
				});
			});
            </script>
        <?
		break;
		case 'manage-user':
			?>
			<script type="text/javascript">
				$(document).ready(function() {
					<?
					if (!empty($uid)): 
						$uid = $_SESSION['uid'];
						unset($_SESSION['uid']);
						?>ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=edit&uid=<?=$uid?>","GET");<?
					else:
						$page = isset($page) ? $page : '0';
						?>ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&page=<?=$page?>","GET");<?
					endif;
					?>
				});
			</script>
			
			<div id="loadajax" align="center">
				<div class="spacer_100 clean"><!-- SPACER --></div>
				<img src="<?=__IMAGE__?>load.gif" class="clean" />
				<div class="spacer_5 clean"><!-- SPACER --></div>
				<span class="shadow pt_8">Please wait...</span>
			</div>
			
			<div id="ajax" class="hidden"></div>
			<?
		break;
		case 'add-group':
			?>
            <form method="post" enctype="multipart/form-data" action="<?=__ROOT__?>/index.php?file=action&action=add-group" id="addusergroupForm">
        	<div style="width:100%;" align="left" class="shadow gray">
        		
        		<div class="spacer_20 clean"><!-- SPACER --></div>
            	<strong>Add User Group:</strong>
            	<div class="spacer_5 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_5 clean"><!-- SPACER --></div>
        		<table width="500" border="0" cellpadding="0" cellspacing="5">  
                    <tr class="line_20">
                        <td width="220"><strong>Group Name:</strong></td>
                        <td><input id="user_group" name="user_group" type="text" class="inputtext default_inputtext" maxlength="50" /></td>
                    </tr>
				</table>
				
            	<div class="spacer_20 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_5 clean"><!-- SPACER --></div>
                <strong>Module Access:</strong> 
                <span style="padding-left:126px;">Yes</span> 
                <span style="padding-left:25px;">No</span>
                <div class="spacer_5 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_0 clean"><!-- SPACER --></div>
				    
                <table width="500" border="0" cellpadding="0" cellspacing="5">  
                    <tr class="line_20">
                        <td width="220">Control Panel: </td>
                        <td width="8%">
                        	<input type="radio" value="1" name="user_group_controlpanel" /> 
                        </td>
                        <td>    
                        	<input type="radio" value="0" name="user_group_controlpanel" checked="checked" />
                        </td>
                    </tr>
                    <tr class="line_20">
                        <td>Dashboard: </td>
                        <td>
                        	<input type="radio" value="1" name="module_dashboard" /> 
                        </td>
                        <td>    
                        	<input type="radio" value="0" name="module_dashboard" checked="checked" />
                        </td>
                    </tr>
                    <tr class="line_20">
                        <td>User: </td>
                        <td>
                        	<input type="radio" value="1" name="module_user" /> 
                        </td>
                        <td>    
                        	<input type="radio" value="0" name="module_user" checked="checked" />
                        </td>
                    </tr>
                    <tr class="line_20">
                        <td>User Group: </td>
                        <td>
                        	<input type="radio" value="1" name="module_user_group" /> 
                        </td>
                        <td>    
                        	<input type="radio" value="0" name="module_user_group" checked="checked" />
                        </td>
                    </tr>
                    <tr class="line_20">
                        <td>Product: </td>
                        <td>
                        	<input type="radio" value="1" name="module_product" /> 
                        </td>
                        <td>    
                        	<input type="radio" value="0" name="module_product" checked="checked" />
                        </td>
                    </tr>
                </table>
                
                <div class="spacer_20 clean"><!-- SPACER --></div>
                <div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_5 clean"><!-- SPACER --></div>
            	<strong>Module Permission:</strong>
            	<span style="padding-left:98px;">Add</span> 
                <span style="padding-left:18px;">Edit</span>
                <span style="padding-left:12px;">Delete</span> 
                <div class="spacer_5 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_0 clean"><!-- SPACER --></div>
                
                <table width="500" border="0" cellpadding="0" cellspacing="5">  
                    <tr class="line_20">
                        <td width="220">User: </td>
                        <td width="8%"><input type="checkbox" name="module_user_add" /></td>
                        <td width="8%"><input type="checkbox" name="module_user_edit" /></td>
                        <td><input type="checkbox" name="module_user_delete" /></td>
					</tr>
					<tr class="line_20">
                        <td>User Group: </td>
                        <td><input type="checkbox" name="module_user_group_add" /></td>
                        <td><input type="checkbox" name="module_user_group_edit" /></td>
                        <td><input type="checkbox" name="module_user_group_delete" /></td>
					</tr>
					<tr class="line_20">
                        <td>Product: </td>
                        <td><input type="checkbox" name="module_product_add" /></td>
                        <td><input type="checkbox" name="module_product_edit" /></td>
                        <td><input type="checkbox" name="module_product_delete" /></td>
					</tr>
                </table>
                
                <div class="spacer_40 clean"><!-- SPACER --></div>
                
                <div style="width:100%;" align="left">
                <input name="clear" type="reset" value="Reset Form" class="button" />
                <input name="save" type="submit" value="Add Group" class="button" />
                </div>
			</div>
			</form>
			<script type="text/javascript">
				$(document).ready(function() {
					$('input[type="reset"]').click(function(){
			            clearForm(this.form);
			        });

	            	$("#addusergroupForm").validate({
						rules: {
							user_group : {
								required: true,
								remote: "<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=usergroup"
							}
						},
						messages: {
							user_group : {
								required: "Please provide a user group name",
								remote: "User group not available."
							}
						},
						onkeyup: false,
				  		onblur: true
					});

				});
			</script>
            <?
		break;
		case 'manage-group':
			?>
			<script type="text/javascript">
				$(document).ready(function() {
					<?
					if (!empty($_SESSION['ugid'])):
						?>ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=edit-group&gid="+<?=$ugid?>,"GET");<?
						unset($_SESSION['ugid']); 
					else:
						$page = isset($page) ? $page : '0';
						?>ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group","GET");<?
					endif;
					?>
				});
			</script>
			
			<div id="loadajax" align="center">
				<div class="spacer_100 clean"><!-- SPACER --></div>
				<img src="<?=__IMAGE__?>load.gif" class="clean" />
				<div class="spacer_5 clean"><!-- SPACER --></div>
				<span class="shadow pt_8">Please wait...</span>
			</div>
			
			<div id="ajax" class="hidden"></div>
			<?
		break;	
		default:
			include dirname(__FILE__) . "/error.php";
		break;
	endswitch;
endif;
?>


