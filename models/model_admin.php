 <?php

 class model_admin extends model
 {
public $groups = array();
 
 function get_users()
 {
	include '/core/db_connect.php'; //$db_conn - var to db connect
	$query = "SELECT users.id as uid, users.name as uname, groups.name as gname, groups.id as gid FROM users inner join groups on users.group=groups.id" or die("Error in the consult.." . mysqli_error($db_conn)); //query
	$result = $db_conn->query($query);
	return $result;
 }
 
 function get_grouplist()
 {
	include '/core/db_connect.php'; //$db_conn - var to db connect
	$query = "SELECT groups.id as gid, groups.name as gname FROM groups" or die("Error in the consult.." . mysqli_error($db_conn)); //query
	$groupslist = $db_conn->query($query);
	while($row2 = mysqli_fetch_array($groupslist))
	{
		$this->groups["$row2[gid]"] = $row2[gname];
	}
 }

function delete_user($id)
{
	include '/core/db_connect.php'; //$db_conn - var to db connect
	$query = 'delete from users where id="'.$id.'"' or die("Error in the consult.." . mysqli_error($db_conn));
	if(!$db_conn->query($query)) return false;
	else return true;
}
function update_user($uname,$group,$id)
{
	include '/core/db_connect.php'; //$db_conn - var to db connect	
	$query = 'update users set users.name="'.$uname.'", users.group="'.$group.'" where id="'.$id.'"' or die("Error in the consult.." . mysqli_error($db_conn));
	if(!$db_conn->query($query)) return false;
	else return true;
}
 }
?>