<?php
class secure
{
static function filter($str) //filter function
{
$orig = $str;

$str = strip_tags($str);	
$str = htmlspecialchars($str);
$str = mysql_escape_string($str);
if($orig==$str) return $str;
else
{
	require_once '/core/view.php';
	require_once '/core/model.php';
	$mdl = new model();
	$view = new view();
	$view->model = $mdl;
	$mdl->err_msg="Forbidden symbols detected!";
	$view->generate('fail_view.php','template_view.php');
	exit;
}	
}
static function check_rights($action)
{
	require_once '/core/model.php';
	$mdl = new model();
	$db_conn = $mdl->db_connect();

	$group = 4;
	if(isset($_SESSION['group'])) $group = $_SESSION['group'];
	$sql = "SELECT permissions.access FROM permissions inner join actions on actions.id=permissions.action_id WHERE (permissions.group_id=? and actions.action=?);"; //query
	if ($stmt = $db_conn->prepare($sql)) 
	{
		$stmt->bind_param('is', $group,$action);				
		$stmt->execute();
	}
	else 
	{
		echo $stmt->errno;
		return false;
	}
	$stmt->bind_result($access);
	$stmt->fetch();
    $stmt->close();
	$mdl->db_disconnect();
	if($access)
			return $access;
	else
	{
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('Location:'.$host.'403');
	}
}
}
?>