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
static function check_rights($author_id,$action)
{
	require_once '/core/model.php';
	$mdl = new model();
	$db_conn = $mdl->db_connect();

	$group = 4;
	if(isset($_SESSION['group'])) $group = $_SESSION['group'];
	
	$sql = "SELECT * FROM groups WHERE id=?;"; //query
	if ($stmt = $db_conn->prepare($sql)) 
	{
		$stmt->bind_param('i', $group);				
		$stmt->execute();
	}
	else 
	{
		return false;
	}
	
	$result = $stmt->get_result();
    
	if($row = mysqli_fetch_array($result))
	{
		if($action=='add_news') 
		{
			if($row['add_news']) return true;
			else return false;
		}
		if($action=='admin') 
		{
			if($row['admin']) return true;
			else return false;
		}
		if($_SESSION['user_id']==$author_id) $action=$action.'_their';
		else $action=$action.'_all';
		if($row[$action]) return true;
		else return false;
	}
	else
	{
		return false;
	}
}
}
?>