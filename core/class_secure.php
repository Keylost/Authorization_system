<?php
class secure
{
static function filter($str) //filter function
{
$str = strip_tags($str);	
$str = htmlspecialchars($str);
$str = mysql_escape_string($str);
return $str;	
}
static function check_rights($author_id,$action)
{
	include "/core/db_connect.php"; //$db_conn - var to db connect
	$group = 4;
	if(isset($_SESSION['group'])) $group = $_SESSION['group'];
	
	$query = "SELECT * FROM groups WHERE id='".$group."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
	$result = $db_conn->query($query);

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