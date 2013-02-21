<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

if(empty($_GET['file'])): 
	include dirname(__FILE__) . "/error.php";
	exit();
else:
	$module_access[0] = $user_access['module_dashboard'];
	$module_access[1] = $user_access['module_user'];
	$module_access[1][1] = $user_access['module_user_add'];
	$module_access[1][2] = $user_access['module_user_edit'];
	$module_access[1][3] = $user_access['module_user_delete'];
	$module_access[2] = $user_access['module_user_group'];
	$module_access[2][1] = $user_access['module_user_group_add'];
	$module_access[2][2] = $user_access['module_user_group_edit'];
	$module_access[2][3] = $user_access['module_user_group_delete'];
	$module_access[3] = $user_access['module_product'];
	$module_access[3][1] = $user_access['module_product_add'];
	$module_access[3][2] = $user_access['module_product_edit'];
	$module_access[3][3] = $user_access['module_product_delete'];
	
	// printr($module_access);
	?>
	<!-- MENU -->
	<div class="box-menu radius_5 gradient shadow pt_8 float_left block" style="width:16%;">
		<div style="width:100%;">
			<div style="padding:5px 5px 0px 5px;">
				<ul class="accordion" id="accordion">
					<?
					if ($module_access[0] == '1'): 
						?><li><a href="<?=__ROOT__?>/?file=cpanel&panel=dashboard" class="clean pt_8 menu line_35 unselectable <?=$panel=='dashboard'?'active':''?>"><span class="pad_left_10 menutext">► Dashboard</span></a></li><?
					endif;
					
					if ($module_access[1][0] == '1'):
					?> 
					<li><a class="clean pt_8 menu line_35 unselectable <?=$panel=='user'?'active':''?>"><span class="pad_left_10 menutext"><?=$panel=='user'?'▼':'►'?> User</span></a>
						<ul>
							<li><a class="<?=$section=='profile'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=user&section=profile">Profile</a></li>
							
							<?
							if ($module_access[1][1] == '1'):
								?><li><a class="<?=$section=='add-user'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=user&section=add-user">Add User</a></li><?
							endif;
							
							if ($module_access[1][2] == '1' || $module_access[1][3] == '1'):
								?><li><a class="<?=$section=='manage-user'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=user&section=manage-user">User Management</a></li><?
							endif;
							
							if ($module_access[2][0] == '1'):
								if ($module_access[2][1] == '1'):
		                        	?><li><a class="<?=$section=='add-group'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=user&section=add-group">Add User Group</a></li><?
								endif;
								
								if ($module_access[2][2] == '1' || $module_access[2][3] == '1'):
									?><li><a class="<?=$section=='manage-group'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=user&section=manage-group">User Group Management</a></li><?
								endif;
							endif;
							?>
						 </ul>   
					</li>
					<? 
					endif;
					
					if ($module_access[3][0] == '1'):
					?>
					<li><a class="clean pt_8 menu line_35 unselectable <?=$panel=='product'?'active':''?>"><span class="pad_left_10 menutext"><?=$panel=='product'?'▼':'►'?> Product</span></a>
						<ul>
							<?
							if ($module_access[3][1] == '1'):
								?><li><a class="<?=$section=='add-product'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=product&section=add-product">Import Product</a></li><?
							endif;
							
							if ($module_access[3][2] == '1' || $module_access[3][3] == '1'):
								?><li><a class="<?=$section=='manage-product'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=product&section=manage-categories">Product Management</a></li><?
							endif;
							?>
						 </ul>   
					</li>
					<?
					endif;
					?>
					
					<li><a class="clean pt_8 menu line_35 unselectable <?=$panel=='coupon'?'active':''?>"><span class="pad_left_10 menutext"><?=$panel=='coupon'?'▼':'►'?> Coupon</span></a>
						<ul>
							<li><a class="<?=$section=='add-coupon'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=coupon&section=add-coupon">Add Coupon</a></li>
							<li><a class="<?=$section=='coupon'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=coupon&section=coupon">Coupon Management</a></li>
						 </ul>
					</li>
					
					<li><a class="clean pt_8 menu line_35 unselectable <?=$panel=='report'?'active':''?>"><span class="pad_left_10 menutext"><?=$panel=='report'?'▼':'►'?> Report</span></a>
						<ul>
							<li><a class="<?=$section=='stock'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=report&section=stock">Stock Availablility Status</a></li>
						 </ul>   
					</li>
					
					<li><a class="clean pt_8 menu line_35 unselectable <?=$panel=='admin'?'active':''?>"><span class="pad_left_10 menutext"><?=$panel=='admin'?'▼':'►'?> Administration</span></a>
						<ul>
							<li><a class="<?=$section=='inventory'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=admin&section=inventory">Inventory Management</a></li>
							<li><a class="<?=$section=='order'?'active':''?>" href="<?=__ROOT__?>/?file=cpanel&panel=admin&section=order">Order Management</a></li>
						 </ul>   
					</li>
				</ul>
			</div>
		</div> 
	</div>
	<!-- EOF MENU -->
<?
endif;
?>