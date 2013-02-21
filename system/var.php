<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

$dataMonth = array (
	array ('value'=>1,'name'=>'Jan'),
	array ('value'=>2,'name'=>'Feb'),
	array ('value'=>3,'name'=>'Mar'),
	array ('value'=>4,'name'=>'Apr'),
	array ('value'=>5,'name'=>'May'),
	array ('value'=>6,'name'=>'Jun'),
	array ('value'=>7,'name'=>'Jul'),
	array ('value'=>8,'name'=>'Aug'),
	array ('value'=>9,'name'=>'Sep'),
	array ('value'=>10,'name'=>'Oct'),
	array ('value'=>11,'name'=>'Nov'),
	array ('value'=>12,'name'=>'Dec')
);

$dataLimit = array (	
	array ('value'=>'all','name'=>'All'),
	array ('value'=>'5','name'=>'5'),
	array ('value'=>'10','name'=>'10'),
	array ('value'=>'20','name'=>'20'),
	array ('value'=>'30','name'=>'30'),
	array ('value'=>'40','name'=>'40'),
	array ('value'=>'50','name'=>'50'),
	array ('value'=>'100','name'=>'100')
);

$userstatusdata = array(
	array ('value'=>'01','name'=>'Pending'),
	array ('value'=>'02','name'=>'Active'),
	array ('value'=>'03','name'=>'Delete')
);

$usersortdata = array (
	array ('value'=>'user_id','name'=>'Default'),
	array ('value'=>'user_name','name'=>'Username'),	
	array ('value'=>'user_email','name'=>'Email'),
	array ('value'=>'user_firstname','name'=>'Firstname'),
	array ('value'=>'user_lastname','name'=>'Lastname'),
	array ('value'=>'user_created','name'=>'Registration Date'),
	array ('value'=>'user_status','name'=>'User Status'),
	array ('value'=>'user_group_id','name'=>'User Group')
);

$usergroupdata = array (
	array ('value'=>'1','name'=>'Guest'),
	array ('value'=>'2','name'=>'Member'),
	array ('value'=>'5','name'=>'Writer'),
	array ('value'=>'6','name'=>'Editor'),
	array ('value'=>'7','name'=>'Admin')
);	

$usergroupsortdata = array (
	array ('value'=>'user_group_id','name'=>'Default'),
	array ('value'=>'user_group','name'=>'Name'),
	array ('value'=>'user_group_status','name'=>'Status')
);

$countLimit = count($dataLimit);
$countMonth = count($dataMonth);
$userstatuscount = count($userstatusdata);
$usersortcount = count($usersortdata);
$usergroupsortcount = count($usergroupsortdata);
$usergroupcount = count($usergroupdata);
?>