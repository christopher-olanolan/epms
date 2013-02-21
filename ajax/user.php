<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

if ($ajax=="" || empty($ajax)):
	include dirname(__FILE__) . "/error.php";
else:
	$connect = new MySQL();
	$connect->connect($config['DB']['LOCAL']['USERNAME'],$config['DB']['LOCAL']['PASSWORD'],$config['DB']['LOCAL']['DATABASE'],$config['DB']['LOCAL']['HOST']);
	
	switch($control):
		// AJAX: FORGET PASSWORD
		case 'forget':
			$query = $connect->single_result_array("SELECT user_id FROM epms_user WHERE user_email = '$user_email'");
			$result = empty($query['user_id']) || $query['user_id'] == 'D' || $query['user_id'] == "" ? "false":"true";
			echo $result;
		break;
		// EOF AJAX: FORGET PASSWORD
		
		// AJAX: USER NAME
		case 'username':
			$query = $connect->single_result_array("SELECT user_id FROM epms_user WHERE user_name = '$user_name'");
			$result = empty($query['user_id']) || $query['user_id'] == 'D' || $query['user_id'] == "" ? "true":"false";
			echo $result;
		break;
		// EOF AJAX: USER NAME
		
		// AJAX: EMAIL
		case 'email':
			$query = $connect->single_result_array("SELECT user_email FROM epms_user WHERE user_email = '$user_email'");
			$result = empty($query['user_email']) || $query['user_email'] == 'D' || $query['user_email'] == "" ? "true":"false";
			echo $result;
		break;
		// EOF AJAX: EMAIL
		
		// AJAX: PROFILE EMAIL
		case 'useremail':
			$query = $connect->single_result_array("SELECT user_email FROM epms_user WHERE user_email = '$user_email' AND user_id != '$id'");
			$result = empty($query['user_email']) || $query['user_email'] == 'D' || $query['user_email'] == "" ? "true":"false";
			echo $result;
		break;
		// EOF AJAX: PROFILE EMAIL
		
		// AJAX: USER GROUP
		case 'usergroup':
			$where = isset($gid) ? "AND user_group_id != '$gid'":"";
			$query = $connect->single_result_array("SELECT user_group FROM epms_user_group WHERE user_group = '$user_group' $where");
			$result = empty($query['user_group']) || $query['user_group'] == 'D' || $query['user_group'] == "" ? "true":"false";
			echo $result;
		break;
		// EOF AJAX: USER GROUP
		
		// AJAX: OLD PASSWORD
		case 'old-password':
			$md5password = md5($old_password);
			$query = $connect->single_result_array("SELECT user_password FROM epms_user WHERE user_id = '$id'");
			$result = $query['user_password'] == $md5password ? "true":"false";
			echo $result;
		break;
		// EOF AJAX: OLD PASSWORD
		
		// EDIT USER
		case 'edit':
			$profile = $connect->single_result_array("SELECT * FROM epms_user WHERE user_id = '$uid'");
			
			$user_name = $profile['user_name'];
			$user_email = $profile['user_email'];
			$user_firstname = $profile['user_firstname'];
			$user_lastname = $profile['user_lastname'];
			$login_group_id = $profile['user_group_id'];

			$select = new Select();
			$select_user_group =  $select->option_query(
					'epms_user_group', 				// table name
					'user_group_id',  				// name='$name' 
					'user_group_id', 				// id='$id'
					'user_group_id',				// value='$value'
					'user_group',					// option name
					$login_group_id,				// default selected value
					'user_group_status = "1" 
					AND user_group_id != "1"',		// query condition(s)  
					'user_group',					// 'order by' field name
					'ASC',							// sort order 'asc' or 'desc'
					'selectoption default_select',	// css class
					'Choose Group',					// default null option name 'Choose option...'	
					'0'								// select type 1 = multiple or 0 = single
				);
			?>
			<form method="post" enctype="multipart/form-data" action="<?=__ROOT__?>/index.php?file=action&action=edit-user" id="editUserForm">
			<input type="hidden" name="user_id" value="<?=$uid?>" />	
        	<div style="width:100%;" align="left" class="shadow gray">
            	<div class="spacer_3 clean"><!-- SPACER --></div>
            	<strong>General Information:</strong>
                <div class="spacer_5 clean"><!-- SPACER --></div>
            	<div class="title_div"><!-- DIVIDER --></div>
                <div class="spacer_0 clean"><!-- SPACER --></div>
                
                <table width="500" border="0" cellpadding="0" cellspacing="5">
                	<tr>
                    	<td width="220">Username: </td>
                        <td class="line_30"><?=$user_name?></td>
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
                <input name="back" type="button" value="Back" class="button" id="back" />
                <input name="clear" type="reset" value="Reset Form" class="button" />
                <input name="save" type="submit" value="Save" class="button" />
                </div>
            </div>
            </form>
            <script type="text/javascript">
				$(document).ready(function() {
					$('#back').click(function(){
						ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user","GET");
					});
					
					$('input[type="reset"]').click(function(){
			            clearForm(this.form);
			        });
			        
					$("#editUserForm").validate({
						rules: {
							old_password : {
								required: false,
								remote: "<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=old-password&id=<?=$profile['user_id']?>"
							},
							user_email : {
								required: true,
								email: true 
								
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
								email: "Please provide a valid email address" 
								
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
		// EOF EDIT USER
		
		// EDIT GROUP
		case 'edit-group':
			if (empty($gid) || $gid == 'D' || $gid == ""):
				?>
				<div align="center" class="shadow gray">
	        		<div class="spacer_50 clean"><!-- SPACER --></div>
					Please choose a user group.
				</div>
				<?
			else:
				$group = $connect->single_result_array("SELECT * FROM epms_user_group WHERE user_group_id = '$gid'");
				extract($group);
	
				// printr($group);
				?>
				<form method="post" enctype="multipart/form-data" action="<?=__ROOT__?>/index.php?file=action&action=delete-group">
				<input type="hidden" name="user_group_id" value="<?=$gid?>" />
				<input type="hidden" name="user_group_status" value="<?=$user_group_status=='0'?'1':'0'?>" />
				
	        	<div style="width:100%;" align="left" class="shadow gray">
	        		
	        		<div class="spacer_20 clean"><!-- SPACER --></div>
					<table width="500" border="0" cellpadding="0" cellspacing="5">  
	                    <tr class="line_20">
	                        <td width="220">Group Status:</td>
	                        <td>
	                        	<strong><?=$user_group_status==1?'<span class="green">Active</span>':'<span class="warning">Not-active</span>'?></strong> &nbsp;&nbsp;&nbsp;
	                        	<?
	                        	if ($user_group_status == 1):
	                        		?><input name="delete" type="submit" value="Delete Group" class="button small_button" /><?
								else:
									?><input name="activate" type="submit" value="Activate Group" class="button small_button" /><?
	                        	endif;
	                        	?>
	                        </td>
	                    </tr>
					</table>
				</div>
				</form>
					
	            <form method="post" enctype="multipart/form-data" action="<?=__ROOT__?>/index.php?file=action&action=edit-group" id="editusergroupForm">
				<input type="hidden" name="user_group_id" value="<?=$gid?>" />
	        	<div style="width:100%;" align="left" class="shadow gray">
	        		<table width="500" border="0" cellpadding="0" cellspacing="5">  
	                    <tr class="line_20">
	                        <td width="220">Group Name:</td>
	                        <td><input id="user_group" name="user_group" type="text" class="inputtext default_inputtext" maxlength="50" value="<?=$user_group?>" /></td>
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
	                        	<input type="radio" value="1" name="user_group_controlpanel" <?=$user_group_controlpanel=='1'?'checked="checked"':''?> /> 
	                        </td>
	                        <td>    
	                        	<input type="radio" value="0" name="user_group_controlpanel" <?=$user_group_controlpanel=='0'?'checked="checked"':''?> />
	                        </td>
	                    </tr>
	                    <tr class="line_20">
	                        <td>Dashboard: </td>
	                        <td>
	                        	<input type="radio" value="1" name="module_dashboard" <?=$module_dashboard=='1'?'checked="checked"':''?> /> 
	                        </td>
	                        <td>    
	                        	<input type="radio" value="0" name="module_dashboard" <?=$module_dashboard=='0'?'checked="checked"':''?> />
	                        </td>
	                    </tr>
	                    <tr class="line_20">
	                        <td>User: </td>
	                        <td>
	                        	<input type="radio" value="1" name="module_user" <?=$module_user=='1'?'checked="checked"':''?> /> 
	                        </td>
	                        <td>    
	                        	<input type="radio" value="0" name="module_user" <?=$module_user=='0'?'checked="checked"':''?> />
	                        </td>
	                    </tr>
	                    <tr class="line_20">
	                        <td>User Group: </td>
	                        <td>
	                        	<input type="radio" value="1" name="module_user_group" <?=$module_user_group=='1'?'checked="checked"':''?> /> 
	                        </td>
	                        <td>    
	                        	<input type="radio" value="0" name="module_user_group" <?=$module_user_group=='0'?'checked="checked"':''?> />
	                        </td>
	                    </tr>
	                    <tr class="line_20">
	                        <td>Product: </td>
	                        <td>
	                        	<input type="radio" value="1" name="module_product" <?=$module_product=='1'?'checked="checked"':''?> /> 
	                        </td>
	                        <td>    
	                        	<input type="radio" value="0" name="module_product" <?=$module_product=='0'?'checked="checked"':''?> />
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
	                        <td width="8%"><input type="checkbox" name="module_user_add" <?=$module_user_add=='1'?'checked="checked"':''?> /></td>
	                        <td width="8%"><input type="checkbox" name="module_user_edit" <?=$module_user_edit=='1'?'checked="checked"':''?> /></td>
	                        <td><input type="checkbox" name="module_user_delete" <?=$module_user_delete=='1'?'checked="checked"':''?> /></td>
						</tr>
						<tr class="line_20">
	                        <td>User Group: </td>
	                        <td><input type="checkbox" name="module_user_group_add" <?=$module_user_group_add=='1'?'checked="checked"':''?> /></td>
	                        <td><input type="checkbox" name="module_user_group_edit" <?=$module_user_group_edit=='1'?'checked="checked"':''?> /></td>
	                        <td><input type="checkbox" name="module_user_group_delete" <?=$module_user_group_delete=='1'?'checked="checked"':''?> /></td>
						</tr>
						<tr class="line_20">
	                        <td>Product: </td>
	                        <td><input type="checkbox" name="module_product_add" <?=$module_product_add=='1'?'checked="checked"':''?> /></td>
	                        <td><input type="checkbox" name="module_product_edit" <?=$module_product_edit=='1'?'checked="checked"':''?> /></td>
	                        <td><input type="checkbox" name="module_product_delete" <?=$module_product_delete=='1'?'checked="checked"':''?> /></td>
						</tr>
	                </table>

	                <div class="spacer_40 clean"><!-- SPACER --></div>
	                
	                <div style="width:100%;" align="left">
	                <input name="back" type="button" value="Back" class="button" id="back" />	
	                <input name="clear" type="reset" value="Reset Form" class="button" />
	                <input name="save" type="submit" value="Save" class="button" />
	                </div>
				</div>
				</form>
				<script type="text/javascript">
					$(document).ready(function() {
						$('#back').click(function(){
							ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group","GET");
						});
					
						$('input[type="reset"]').click(function(){
				            clearForm(this.form);
				        });

		            	$("#editusergroupForm").validate({
							rules: {
								user_group : {
									required: true,
									remote: "<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=usergroup&gid=<?=$gid?>"
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
	            <? // printr($group);
			endif;
		break;
		// EOF EDIT GROUP
		
		// MANAGE GROUP
		case "manage-group":
			$user_group_order = $user_group_order!="" ? $user_group_order:'user_group_id';
			$user_group_dir = $user_group_dir!="" ? $user_group_dir:'ASC';
			
			$_SESSION['sort_group_order'] = $user_group_order;
			$_SESSION['sort_group_dir'] = $user_group_dir;
			
			$sort_group_order = $_SESSION['sort_group_order'];
			$sort_group_dir = $_SESSION['sort_group_dir'];

			$query_total = isset($sort_limit) ? $sort_limit : __LIMIT__;
			$sort_limit = $query_total;
			$page = isset($page) ? $page : '0';
			$query_page = $page*$sort_limit;
			$limit = $sort_limit == "all"? '':'LIMIT '.$query_page.','.$query_total;
			$query_search = $search != "" ? ' AND user_group LIKE "%'.$search.'%" ' : ' '; 
			
			$user_group_max_list = $connect->get_array_result("
				SELECT 
					user_group_id
				FROM epms_user_group
				WHERE
					user_group_id != '1'".$query_search);
					
			$user_group_list = $connect->get_array_result("
				SELECT 
					t1.*,
					t2.*
				FROM epms_user_group AS t1
					LEFT JOIN epms_user_status AS t2 ON t1.user_group_status = t2.user_status_id
				WHERE
					t1.user_group_id != '1'".$query_search."
				ORDER BY
					t1.".$sort_group_order." ".$sort_group_dir." ".$limit);
			
			$count_user_group_max_list = count($user_group_max_list);							
			$count_user_group_list = count($user_group_list);
			extract($user_group_list);
			
			$prev = $page == 'all' ? '0':($page)-1;
			$next = $page == 'all' ? '0':($page)+1;
			$max = $count_user_group_max_list / $query_total;
			
			// printr($user_group_list);
		?>
			<script type="text/javascript">
            $(document).ready(function() {
				$('.confirm').click(function(){
					$.confirm({
						'title'		: 'Delete Confirmation',
						'message'	: 'You are about to delete this group. Continue?',
						'buttons'	: {
							'Yes'	: {
								'class'	: 'blue',
								'action': function(){return true;}
							},
							'No'	: {
								'class'	: 'gray',
								'action': function(){return false;}
							}
						}
					});
					
				});
				
                $('#checkbox').click(function(){
                    var isChecked = $(this).attr('checked')?true:false;
                    if(isChecked){
                        $("#multi-active").removeAttr('disabled');
                        $("#multi-pending").removeAttr('disabled');
                        $("#multi-delete").removeAttr('disabled');
                        $("#multi-cancel").removeAttr('disabled');
                        $(".list").find("input:checkbox").attr('checked',$(this).is(":checked"));
                    } else {
                        $("#multi-active").attr('disabled','disabled');
                        $("#multi-pending").attr('disabled','disabled');
                        $("#multi-delete").attr('disabled','disabled');
                        $("#multi-cancel").attr('disabled','disabled');
                        $(".list").find("input:checkbox").removeAttr('checked');
                    }
                });
                
                $('.checkbox').click(function(){
                    var isChecked = false;
                                                
                    $("input.checkbox").each( function() {
                        if ($(this).attr("checked") == 'checked'){
                            isChecked = true;
                        }
                    });
        
                    if (isChecked == true){
                        $("#multi-active").removeAttr('disabled');
                        $("#multi-pending").removeAttr('disabled');
                        $("#multi-delete").removeAttr('disabled');
                        $("#multi-cancel").removeAttr('disabled');
                        $("#checkbox").attr('checked',"checked");
                    } else {
                        $("#multi-active").attr('disabled','disabled');
                        $("#multi-pending").attr('disabled','disabled');
                        $("#multi-delete").attr('disabled','disabled');
                        $("#multi-cancel").attr('disabled','disabled');
                        $("#checkbox").removeAttr('checked');
                    }
                });
                
                $('.editPop').CreateBubblePopup({
                    position: 'left',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Click to edit user group.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.deletePop').CreateBubblePopup({
                    position: 'left',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Click to delete user group.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.activatePop').CreateBubblePopup({
                    position: 'left',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Click to activate user group.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('div.pending').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'User Group pending.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('div.delete').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'User Group deleted.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('div.active').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'User Group active.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('div.cancelled').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'User Group cancelled.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.pendingMultiPop').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Set <img src="images/ico_checked.png" align="absmiddle" /> user group(s) to pending.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.activeMultiPop').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Set <img src="images/ico_checked.png" align="absmiddle" /> user group(s) to active.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.cancelMultiPop').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Cancel <img src="images/ico_checked.png" align="absmiddle" /> user group(s).', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.deleteMultiPop').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Delete <img src="images/ico_checked.png" align="absmiddle" /> user group(s).', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
				
				$('#user_group_sort_status').change(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_group_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search,"GET");
				});
				
				$('#user_group_sort_status').keyup(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_group_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search,"GET");
				});
				
				$('#user_group_sort').change(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_group_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search,"GET");
				});
				
				$('#user_group_sort').keyup(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_group_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search,"GET");
				});
				
				$('#sort_limit').change(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_group_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search,"GET");
				});
				
				$('#sort_limit').keyup(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_group_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search,"GET");
				});
				
				$('#nav-prev').click(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_group_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search+"&page="+<?=$prev?>,"GET");
				});
				
				$('#nav-next').click(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_group_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search+"&page="+<?=$next?>,"GET");
				});
				
				$('#btn-search').click(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_group_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search+"&page=0","GET");
				});
				
				$('#search').bind('keypress', function(e) {
					var code = (e.keyCode ? e.keyCode : e.which);
					if(code == 13) { //Enter keycode
						var user_group_order = $('#user_group_sort_status option:selected').val();
						var user_group_dir = $('#user_group_sort option:selected').val();
						var sort_limit = $('#sort_limit option:selected').val();
						sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
						var user_group_search = $('#search').val();
						ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&user_group_order="+user_group_order+"&user_group_dir="+user_group_dir+"&sort_limit="+sort_limit+"&search="+user_group_search+"&page=0","GET");
					 }
				});
				
				$('#clear-search').click(function() {
					var user_group_order = $('#user_group_sort_status option:selected').val();
					var user_group_dir = $('#user_group_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == "undefined" ? "<?=__LIMIT__?>":sort_limit;
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-group&sort_limit="+sort_limit+"&page=0","GET");
				});
				
            });
            </script>
            <div style="width:100%;" align="left" class="shadow gray">
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr class="line_20">
                    <td align="px_10" valign="middle">
                        <div class="float_left px_10">
	                        Filter:
	                        <input id="search" name="search" type="text" class="inputtext thin_inputtext" maxlength="50" value="<?=$search?>" />
	                        <input type="button" class="button small_button" value="Search" id="btn-search">
	                        <input type="button" class="button small_button" value="Reset" id="clear-search">
                        </div>
                        
                        <div class="float_right px_10">
	                        Sort:
	                        <select id="user_group_sort_status" name="user_group_sort_status" class="selectoption thin_select pt_8">
	                            <? for ($i=0;$i<$usergroupsortcount;$i++): ?>
	                            <option value="<?=$usergroupsortdata[$i]['value']?>" <?=$sort_group_order==$usergroupsortdata[$i]['value']?"selected=selected":""?>><?=$usergroupsortdata[$i]['name']?></option>
	                            <? endfor; ?>
	                        </select>
	                        <select id="user_group_sort" name="user_group_sort" class="selectoption thin_select pt_8">
	                            <option value="ASC" <?=$sort_group_dir=="ASC"?"selected=selected":""?>>Ascending</option>
	                            <option value="DESC" <?=$sort_group_dir=="DESC"?"selected=selected":""?>>Descending</option>
	                        </select>
                        </div>
                    </td>
                </tr>
            </table>
            
            <div class="spacer_20 clean"><!-- SPACER --></div>
            
            <form action="<?=__ROOT__?>/index.php?file=process&process=manage-group" method="post" enctype="multipart/form-data">
            <table width="100%" border="0" cellpadding="5" cellspacing="0" class="list">
            	<tr class="line_20">
            		<th width="1%" rowspan="3" class="table_solid_right table_solid_bottom unselectable no-color">&nbsp</th>
            		<th width="1%" rowspan="3" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable no-color" valign="bottom"><div class="rotate"><strong>Group Status</strong></div></th>
            		<th rowspan="2" class="table_solid_right unselectable no-color">&nbsp</th>
            		<th width="1%" rowspan="3" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable no-color" valign="bottom"><div class="rotate"><strong>Control Panel</strong></div></th>
                    <th width="1%" rowspan="3" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable no-color" valign="bottom"><div class="rotate"><strong>Dashboard</strong></div></th>
                    <th width="1%" colspan="4" class="table_solid_top table_solid_right px_10 darkgray unselectable" valign="bottom" align="center">User</th>
                    <th width="1%" colspan="4" class="table_solid_top table_solid_right px_10 darkgray unselectable" valign="bottom" align="center">User Group</th>
                    <th width="1%" colspan="4" class="table_solid_top table_solid_right px_10 darkgray unselectable" valign="bottom" align="center">Product</th>
                    <th rowspan="2" class="unselectable no-color">&nbsp</th>
            	</tr>
            	<tr height="40">
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Access</div></th>
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Add</div></th>
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Edit</div></th>
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Delete</div></th>
                    
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Access</div></th>
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Add</div></th>
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Edit</div></th>
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Delete</div></th>
                    
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Access</div></th>
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Add</div></th>
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Edit</div></th>
                    <th width="1%" rowspan="2" class="table_solid_top table_solid_right table_solid_bottom px_10 darkgray unselectable gray" valign="bottom"><div class="rotate">Delete</div></th>
                </tr>
                <tr class="line_20">
                	<th class="table_solid_top table_solid_bottom table_solid_right px_10 darkgray unselectable no-color" align="center">Group Name</th>
                	<th class="table_solid_top table_solid_bottom table_solid_right px_10 darkgray unselectable no-color" align="center">Action</th>
                </tr>
            <?
            if ($count_user_group_list > 0):
	            for($x=0;$x<$count_user_group_list;$x++):
	                // GENERAL INFORMATION
	                $user_group_id = $user_group_list[$x]['user_group_id'];
	                $user_group_status = $user_group_list[$x]['user_group_status'];
					$user_group = $user_group_list[$x]['user_group'];
	                $user_status_class = $user_group_list[$x]['user_status_class'];
	                $user_status = $user_group_list[$x]['user_status'];
	                
	                $user_group_controlpanel = $user_group_list[$x]['user_group_controlpanel'];
					$module_dashboard = $user_group_list[$x]['module_dashboard'];
					
					$module_user = $user_group_list[$x]['module_user'];
					$module_user_add = $user_group_list[$x]['module_user_add'];
					$module_user_edit = $user_group_list[$x]['module_user_edit'];
					$module_user_delete = $user_group_list[$x]['module_user_delete'];
					
					$module_user_group = $user_group_list[$x]['module_user_group'];
					$module_user_group_add = $user_group_list[$x]['module_user_group_add'];
					$module_user_group_edit = $user_group_list[$x]['module_user_group_edit'];
					$module_user_group_delete = $user_group_list[$x]['module_user_group_delete'];
					
					$module_product = $user_group_list[$x]['module_product'];
					$module_product_add = $user_group_list[$x]['module_product_add'];
					$module_product_edit = $user_group_list[$x]['module_product_edit'];
					$module_product_delete= $user_group_list[$x]['module_product_delete'];
					
					
					$total_user = $connect->get_array_result("
						SELECT 
							user_id
						FROM epms_user
							WHERE user_group_id = '$user_group_id'");
					
					$total = count($total_user);
					
	                // BUBBLE INFO
					$user_info  = "<div style='width:250px;' class='pt_8'>";
	                $user_info .= "<b class='green'>Group Name:</b> $user_group <br />"; 
					$user_info .= "<b class='green'>No. of User(s):</b> $total<br />";
					$user_info .= "<b class='green'>Status:</b> $user_status<br />";
	                $user_info .= "<div class='spacer_5 clean'><!-- SPACER --></div>";
					$user_info .= "</div>";
	                
	            ?>
	                <script type="text/javascript">
	                    $(document).ready(function() {
	                        $('#info_<?=$user_group_id?>').CreateBubblePopup({
	                            position: 'top',
	                            align: 'left',
	                            innerHtmlStyle: {color:'#FFFFFF', 'text-align':'left'},
	                            innerHtml: "<?=$user_info?>", 
	                            themeName: 'all-black',
	                            themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
	                        });
	                        
	                        $('#edit_<?=$user_group_id?>').click(function(){
								ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=edit-group&gid=<?=$user_group_id?>","GET");
	                        });
	                    });
	                </script>
	                <tr class="line_20">
	                    <td width="1%" class="table_solid_left table_solid_right table_solid_bottom" align="center">
	                        <input type="checkbox" class="checkbox" name="action[checkbox][]" value="<?=$user_group_id?>" />
	                    </td>
	                    <td width="1%" class="table_solid_right table_solid_bottom" align="center"><div class="<?=$user_status_class?> block"></div></td>
	                    <td width="30%" class="table_solid_bottom table_solid_right">
	                    	<span class="cursor-pointer block" id="info_<?=$user_group_id?>">
	                    		<span class="darkgray"><strong class="px_10"><?=$user_group?></strong>
	                    	</span>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$user_group_controlpanel==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_dashboard==1?'active':'cancelled'?> block"></div>
						</td>
						
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_user==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_user_add==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_user_edit==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_user_delete==1?'active':'cancelled'?> block"></div>
						</td>
						
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_user_group==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_user_group_add==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_user_group_edit==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_user_group_delete==1?'active':'cancelled'?> block"></div>
						</td>
						
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_product==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_product_add==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_product_edit==1?'active':'cancelled'?> block"></div>
						</td>
						<td class="table_solid_right table_solid_bottom" align="center">
							<div class="ico ico_<?=$module_product_delete==1?'active':'cancelled'?> block"></div>
						</td>
						
	                    <td class="table_solid_right table_solid_bottom px_10" align="right">
	                        <input type="button" class="clean editPop ico ico_edit" name="action[single-edit]" value="<?=$user_group_id?>" id="edit_<?=$user_group_id?>" /> Edit &nbsp;&nbsp;
	                        <? if($user_group_status == '1'): ?>
	                        	<input type="submit" class="clean deletePop ico ico_delete confirm" name="action[single-delete]" value="<?=$user_group_id?>" id="delete_<?=$user_group_id?>" title="Are you sure you want to delete this group?" /> Delete
	                        <? else: ?>
	                        	<input type="submit" class="clean activatePop ico ico_active" name="action[single-active]" value="<?=$user_group_id?>" id="active_<?=$user_group_id?>" /> Active
	                        <? endif; ?>
	                    </td>
	                </tr>
	            <?
	            endfor;
	            ?>   
	            </table>
	            
	            <div class="spacer_5 clean"><!-- SPACER --></div>
	            
	            <table width="100%" border="0" cellpadding="6" cellspacing="0">
	                <tr class="line_20">
	                    <td width="1.1%" align="center"><input type="checkbox" id="checkbox" /></td>
	                    <td align="left" class="px_10">
	                        <input type="submit" class="clean activeMultiPop ico ico_active" name="action[multi-active]" id="multi-active" value="true" disabled="disabled" /> Active &nbsp;&nbsp; 
	                        <input type="submit" class="clean pendingMultiPop ico ico_pending" name="action[multi-pending]" id="multi-pending" value="true" disabled="disabled" /> Pending &nbsp;&nbsp; 
	                        <input type="submit" class="clean deleteMultiPop ico ico_delete confirm" name="action[multi-delete]" id="multi-delete" value="true" disabled="disabled" title="Are you sure you want to delete selected group(s)?" /> Delete &nbsp;&nbsp; 
	                        <input type="submit" class="clean cancelMultiPop ico ico_cancelled" name="action[multi-cancel]" id="multi-cancel" value="true" disabled="disabled" /> Cancel &nbsp;&nbsp; 
	                    </td>
	                    <td align="right">
	                    	<? if ($prev >= 0): ?>
		                    	<input type="button" class="button small_button" value="Prev" id="nav-prev">
		                    <? endif; ?>
		                    	
		                    <select id="sort_limit" name="sort_limit" class="selectoption thin_number_select pt_8">
	                            <? for ($i=0;$i<$countLimit;$i++): ?>
	                            <option value="<?=$dataLimit[$i]['value']?>" <?=$sort_limit==$dataLimit[$i]['value']?"selected=selected":""?>><?=$dataLimit[$i]['name']?></option>
	                            <? endfor; ?>
	                        </select>	

	                    	<? if ($next < $max): ?>
	                        	<input type="button" class="button small_button" value="Next" id="nav-next">
	                        <? endif; ?>
	                    </td>
	                </tr>
	            </table>
            <? else: ?>
            	<table width="100%" border="0" cellpadding="6" cellspacing="0" class="list">
	                <tr class="line_20">
	                	<td align="center" class="table_solid_left table_solid_right table_solid_bottom error shadow pt_8"><strong>No Result Found</strong></td>
	                </tr>
				</table>
            <? endif; ?>
            </form>
            </div>
		<?
		break;
		// EOF MANAGE GROUP
		
		// MANAGE USERS
		default:
			// printr($_SESSION);
			// printr($_GET);
			$login_id = decryption($ENCRYPT_ID);
			$user_order = $user_order!="" ? $user_order:'user_id';
			$user_dir = $user_dir!="" ? $user_dir:'ASC';

			$_SESSION['sort_order'] = $user_order;
			$_SESSION['sort_dir'] = $user_dir;
			
			$sort_order = $_SESSION['sort_order'];
			$sort_dir = $_SESSION['sort_dir'];
			
			$query_total = isset($sort_limit) ? $sort_limit : __LIMIT__;
			$sort_limit = $query_total;
			$page = isset($page) ? $page : '0';
			$query_page = $page*$sort_limit;
			$limit = $sort_limit == "all"? '':'LIMIT '.$query_page.','.$query_total;
			$query_search = $search != "" ? ' AND (t1.user_name LIKE "%'.$search.'%" OR t1.user_firstname LIKE "%'.$search.'%" OR t1.user_lastname LIKE "%'.$search.'%" OR t1.user_email LIKE "%'.$search.'%") ' : ' ';
			
			$user_max_list = $connect->get_array_result("
				SELECT 
					t1.user_id 
				FROM epms_user as t1
					LEFT JOIN epms_user_group AS t2 ON t1.user_group_id = t2.user_group_id
				WHERE
					t1.user_id != '$login_id' AND
					t2.user_group_id != '1'".$query_search);
					
			$user_list = $connect->get_array_result("
				SELECT 
					t1.*, 
					
					t2.user_group,
					
					t3.user_status_id,
					t3.user_status,
					t3.user_status_class
				FROM epms_user as t1
					LEFT JOIN epms_user_group AS t2 ON t1.user_group_id = t2.user_group_id
					LEFT JOIN epms_user_status AS t3 ON t1.user_status = t3.user_status_id
				WHERE
					t1.user_id != '$login_id' AND
					t2.user_group_id != '1'".$query_search."
				ORDER BY
					t1.".$sort_order." ".$sort_dir." ".$limit);
		
			$count_user_max_list = count($user_max_list);							
			
			$prev = $page == 'all' ? '0':($page)-1;
			$next = $page == 'all' ? '0':($page)+1;
			$max = $count_user_max_list / $query_total;
			
			// printr($user_list);
			// printr($_SESSION);
			
			$select = new Select();
			$select_user_group =  $select->option_query(
											'epms_user_group', 					// table name
											'user_group',  						// name='$name' 
											'action[multi][group_id]', 			// id='$id'
											'user_group_id',					// value='$value'
											'user_group',						// option name
											'',									// default selected value
											'user_group_status = "1"
											AND user_group_id != "1"',			// query condition(s)    
											'user_group',						// 'order by' field name
											'ASC',								// sort order 'asc' or 'desc'
											'selectoption thin_select pt_8',	// css class
											'Choose Group',						// default null option name 'Choose option...'	
											'0'									// select type 1 = multiple or 0 = single
										);
										
			$count_user_list = count($user_list);
		?>
			<script type="text/javascript">
            $(document).ready(function() {
                $('#checkbox').click(function(){
                    var isChecked = $(this).attr('checked')?true:false;
                    if(isChecked){
                        $("#multi-active").removeAttr('disabled');
                        $("#multi-pending").removeAttr('disabled');
                        $("#multi-delete").removeAttr('disabled');
                        $("#multi-cancel").removeAttr('disabled');
                        $("#multi-group").removeAttr('disabled');
                        $("#user_group").removeAttr('disabled');
                        $(".list").find("input:checkbox").attr('checked',$(this).is(":checked"));
                    } else {
                        $("#multi-active").attr('disabled','disabled');
                        $("#multi-pending").attr('disabled','disabled');
                        $("#multi-delete").attr('disabled','disabled');
                        $("#multi-cancel").attr('disabled','disabled');
                        $("#multi-group").attr('disabled','disabled');
                        $("#user_group").attr('disabled','disabled');
                        $("#user_group").val('0');
                        $(".list").find("input:checkbox").removeAttr('checked');
                    }
                });
                
                $('.checkbox').click(function(){
                    var isChecked = false;
                                                
                    $("input.checkbox").each( function() {
                        if ($(this).attr("checked") == 'checked'){
                            isChecked = true;
                        }
                    });
        
                    if (isChecked == true){
                        $("#multi-active").removeAttr('disabled');
                        $("#multi-pending").removeAttr('disabled');
                        $("#multi-delete").removeAttr('disabled');
                        $("#multi-cancel").removeAttr('disabled');
                        $("#multi-group").removeAttr('disabled');
                        $("#user_group").removeAttr('disabled');
                        $("#checkbox").attr('checked',"checked");
                    } else {
                        $("#multi-active").attr('disabled','disabled');
                        $("#multi-pending").attr('disabled','disabled');
                        $("#multi-delete").attr('disabled','disabled');
                        $("#multi-cancel").attr('disabled','disabled');
                        $("#multi-group").attr('disabled','disabled');
                        $("#user_group").attr('disabled','disabled');
                        $("#user_group").val('0');
                        $("#checkbox").removeAttr('checked');
                    }
                });
                
                $('.editPop').CreateBubblePopup({
                    position: 'left',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Click to edit user.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.deletePop').CreateBubblePopup({
                    position: 'left',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Click to delete user.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.activatePop').CreateBubblePopup({
                    position: 'left',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Click to activate user.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('div.pending').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Account pending.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('div.delete').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Account deleted.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('div.active').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Account active.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('div.cancelled').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Account cancelled.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.pendingMultiPop').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Set <img src="images/ico_checked.png" align="absmiddle" /> account(s) to pending.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.activeMultiPop').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Set <img src="images/ico_checked.png" align="absmiddle" /> account(s) to active.', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.cancelMultiPop').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Cancel <img src="images/ico_checked.png" align="absmiddle" /> account(s).', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
                
                $('.deleteMultiPop').CreateBubblePopup({
                    position: 'right',
                    align: 'center',
                    innerHtmlStyle: {color:'#FFFFFF', 'text-align':'center'},
                    innerHtml: 'Delete <img src="images/ico_checked.png" align="absmiddle" /> account(s).', 
                    themeName: 'all-black',
                    themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
                });
				
				$('#user_sort_status').change(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search,"GET");
				});
				
				$('#user_sort_status').keyup(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search,"GET");
				});
				
				$('#user_sort').change(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search,"GET");
				});
				
				$('#user_sort').keyup(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search,"GET");
				});
				
				$('#sort_limit').change(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search,"GET");
				});
				
				$('#sort_limit').keyup(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search,"GET");
				});
				
				$('#nav-prev').click(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search+"&page="+<?=$prev?>,"GET");
				});
				
				$('#nav-next').click(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search+"&page="+<?=$next?>,"GET");
				});

				$('#btn-search').click(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					var user_search = $('#search').val();
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search+"&page=0","GET");
				});
				
				$('#search').bind('keypress', function(e) {
					var code = (e.keyCode ? e.keyCode : e.which);
					if(code == 13) { //Enter keycode
						var user_order = $('#user_sort_status option:selected').val();
						var user_dir = $('#user_sort option:selected').val();
						var sort_limit = $('#sort_limit option:selected').val();
						sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
						var user_search = $('#search').val();
						ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-user&user_order="+user_order+"&user_dir="+user_dir+"&sort_limit="+sort_limit+"&search="+user_search+"&page=0","GET");
					 }
				});
				
				$('#clear-search').click(function() {
					var user_order = $('#user_sort_status option:selected').val();
					var user_dir = $('#user_sort option:selected').val();
					var sort_limit = $('#sort_limit option:selected').val();
					sort_limit = sort_limit == undefined ? "<?=__LIMIT__?>":sort_limit;
					ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=manage-user&sort_limit="+sort_limit+"&page=0","GET");
				});
				
				$('#user_group').attr("disabled","disabled");
            });
            </script>
            <div style="width:100%;" align="left" class="shadow gray">
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr class="line_20">
                    <td align="right px_10">
                    	<div class="float_left px_10">
	                        Filter:
	                        <input id="search" name="search" type="text" class="inputtext thin_inputtext" maxlength="50" value="<?=$search?>" />
	                        <input type="button" class="button small_button" value="Search" id="btn-search">
	                        <input type="button" class="button small_button" value="Reset" id="clear-search">
                        </div>
                        
                        <div class="float_right px_10">
	                        Sort:
	                        <select id="user_sort_status" name="user_sort_status" class="selectoption thin_select pt_8">
	                            <? for ($i=0;$i<$usersortcount;$i++): ?>
	                            <option value="<?=$usersortdata[$i]['value']?>" <?=$sort_order==$usersortdata[$i]['value']?"selected=selected":""?>><?=$usersortdata[$i]['name']?></option>
	                            <? endfor; ?>
	                        </select>
	                        <select id="user_sort" name="user_sort" class="selectoption thin_select pt_8">
	                            <option value="ASC" <?=$sort_dir=="ASC"?"selected=selected":""?>>Ascending</option>
	                            <option value="DESC" <?=$sort_dir=="DESC"?"selected=selected":""?>>Descending</option>
	                        </select>
                        </div>
                    </td>
                </tr>
            </table>
            
            <form action="<?=__ROOT__?>/index.php?file=process&process=manage-user" method="post" enctype="multipart/form-data">
            <table width="100%" border="0" cellpadding="5" cellspacing="0" class="list table_solid_top">
            <?
            if ($count_user_list > 0):
	            for($x=0;$x<$count_user_list;$x++):
	                // GENERAL INFORMATION
	                $user_id = $user_list[$x]['user_id'];
	                $user_status = $user_list[$x]['user_status'];
					$user_name = $user_list[$x]['user_name'];
	                $user_email = $user_list[$x]['user_email'];
	                $user_group = $user_list[$x]['user_group'];
					$user_group_id = $user_list[$x]['user_group_id'];
					$user_status = $user_list[$x]['user_status'];
					$user_status_id = $user_list[$x]['user_status_id'];
	                $user_status_class = $user_list[$x]['user_status_class'];
	                
	                // PERSONAL INFORMATION
	                $user_firstname = $user_list[$x]['user_firstname'];
	                $user_lastname = $user_list[$x]['user_lastname'];
	
	                // BUBBLE INFO
					$user_info  = "<div style='width:250px;' class='pt_8'>";
	                $user_info .= "<img src='$user_avatar' align='left' class='pad_right_10' />";
	                $user_info .= "<b class='green'>Email:</b> $user_email <br />";
	                $user_info .= "<b class='green'>Group:</b> $user_group <br />"; 
	                $user_info .= "<b class='green'>Alias:</b> $user_name";
	                $user_info .= "<div class='spacer_5 clean'><!-- SPACER --></div>";
	                $user_info .= "<b class='green'>Name:</b> $user_firstname $user_lastname <br />";
					$user_info .= "</div>";
					
					// printr($user_list);
 
	            ?>
	                <script type="text/javascript">
	                    $(document).ready(function() {
	                        $('#info_<?=$user_id?>').CreateBubblePopup({
	                            position: 'right',
	                            align: 'left',
	                            innerHtmlStyle: {color:'#FFFFFF', 'text-align':'left'},
	                            innerHtml: "<?=$user_info?>", 
	                            themeName: 'all-black',
	                            themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
	                        });
	                        
	                        $('#stats_<?=$user_id?>').CreateBubblePopup({
	                            position: 'left',
	                            align: 'left',
	                            innerHtmlStyle: {color:'#FFFFFF', 'text-align':'left'},
	                            innerHtml: "<?=$user_stats?>", 
	                            themeName: 'all-black',
	                            themePath: '<?=__IMAGE__?>jquerybubblepopup-theme/'
	                        });
	                        
	                        $('#edit_<?=$user_id?>').click(function(){
								ajaxLoad("<?=__ROOT__?>/index.php?file=ajax&ajax=user&control=edit&uid=<?=$user_id?>","GET");
	                        });
	                    });
	                </script>
	                <tr class="line_20">
	                    <td width="1%" class="table_solid_left table_solid_right table_solid_bottom" align="center">
	                        <input type="checkbox" class="checkbox" name="action[checkbox][]" value="<?=$user_id?>" />
	                    </td>
	                    <td width="1%" class="table_solid_right table_solid_bottom" align="center"><div class="<?=$user_status_class?> block"></div></td>
	                    <td class="table_solid_bottom">
	                    	<span class="cursor-default" id="info_<?=$user_id?>">
	                    		<?=$name=$user_firstname!=''?'<span class="aqua"><strong>'.$user_firstname.' '.$user_lastname.'</strong></span> &mdash;':''?>
	                    		<span class="darkgray"><strong><?=$user_name?></strong></span> [<i><?=$user_email?></i>] &mdash; <strong class="px_10 green"><?=$user_group?></strong>
	                    	</span>
						</td>
	                    <td class="table_solid_right table_solid_bottom px_10" align="right">
	                        <input type="button" class="clean editPop ico ico_edit" name="action[single-edit]" value="<?=$user_id?>" id="edit_<?=$user_id?>" /> Edit &nbsp;&nbsp;
	                        <? if($user_status_id == '1'): ?>
	                        	<input type="submit" class="clean deletePop ico ico_delete confirm" name="action[single-delete]" value="<?=$user_id?>" id="delete_<?=$user_id?>" title="Are you sure you want to delete this user?" /> Delete
	                        <? else: ?>
	                        	<input type="submit" class="clean activatePop ico ico_active" name="action[single-active]" value="<?=$user_id?>" id="active_<?=$user_id?>" /> Active
	                        <? endif; ?>
	                    </td>
	                </tr>
	            <?
	            endfor;
	            ?>   
	            </table>
	            <table width="100%" border="0" cellpadding="6" cellspacing="0">
	                <tr class="line_20">
	                    <td width="1.1%" align="center"><input type="checkbox" id="checkbox" /></td>
	                    <td align="left" class="px_10">
	                        <input type="submit" class="clean activeMultiPop ico ico_active" name="action[multi-active]" id="multi-active" value="true" disabled="disabled" /> Active &nbsp;&nbsp; 
	                        <input type="submit" class="clean pendingMultiPop ico ico_pending" name="action[multi-pending]" id="multi-pending" value="true" disabled="disabled" /> Pending &nbsp;&nbsp; 
	                        <input type="submit" class="clean deleteMultiPop ico ico_delete confirm" name="action[multi-delete]" id="multi-delete" value="true" disabled="disabled" title="Are you sure you want to delete selected user(s)?" /> Delete &nbsp;&nbsp; 
	                        <input type="submit" class="clean cancelMultiPop ico ico_cancelled" name="action[multi-cancel]" id="multi-cancel" value="true" disabled="disabled" /> Cancel &nbsp;&nbsp; 
	                        <?=$select_user_group?>
	                        <input type="submit" class="button small_button" name="action[multi-group]" id="multi-group" value="Set Group" disabled="disabled" />
	                    </td>
	                    <td align="right">
	                    	<? if ($prev >= 0): ?>
		                    	<input type="button" class="button small_button" value="Prev" id="nav-prev">
		                    <? endif; ?>
		                    	
		                    <select id="sort_limit" name="sort_limit" class="selectoption thin_number_select pt_8">
	                            <? for ($i=0;$i<$countLimit;$i++): ?>
	                            <option value="<?=$dataLimit[$i]['value']?>" <?=$sort_limit==$dataLimit[$i]['value']?"selected=selected":""?>><?=$dataLimit[$i]['name']?></option>
	                            <? endfor; ?>
	                        </select>	

	                    	<? if ($next < $max): ?>
	                        	<input type="button" class="button small_button" value="Next" id="nav-next">
	                        <? endif; ?>
	                    </td>
	                </tr>
	            </table>
	            
			<? else: ?>
            	<table width="100%" border="0" cellpadding="6" cellspacing="0" class="list">
	                <tr class="line_20">
	                	<td align="center" class="table_solid_left table_solid_right table_solid_top table_solid_bottom error shadow pt_8"><strong>No Result Found</strong></td>
	                </tr>
				</table>
            <? endif; ?>
            
            </form>
            </div>
		<?
		break;
		// EOF MANAGE USERS
		
	endswitch;
endif;
?>