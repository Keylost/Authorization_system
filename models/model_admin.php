 <?php
require_once '/core/class_secure.php';
 class model_admin extends model
 {
public $groups = array();
 
 function get_users()
 {
	$sql = "SELECT users.id, users.name, groups.name, groups.id FROM users inner join groups on users.group=groups.id;";
	$db_conn = $this->db_connect();
	if ($stmt = $db_conn->prepare($sql)) 
	{			
		$stmt->execute();
		return $stmt;
	}
	else 
	{
		$this->err_msg="db query error";
		return false;
	}
 }
 
 function get_grouplist()
 {
	$db_conn = $this->db_connect();
	$sql = "SELECT groups.id, groups.name FROM groups;"; //query
	if ($stmt = $db_conn->prepare($sql)) 
	{			
		$stmt->execute();
		$stmt->bind_result($id,$name);
		while($stmt->fetch())
		{
			$this->groups[$id] = $name;		
		}
		$stmt->close();
	}
	else 
	{
		$this->err_msg="db query error";
		return false;
	}
 }

function delete_user($id)
{
	$id = secure::filter($_POST['uid']);
	$db_conn = $this->db_connect();
	$sql = 'delete from users where id=?;';
	if ($stmt = $db_conn->prepare($sql)) 
	{			
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	else 
	{
		$this->err_msg="db query error";
		return false;
	}
}
function update_user($uname,$group,$id)
{
	$uname=secure::filter($uname);
	$group=intval($group);
	$id=intval($id);
	$sql = 'update users set users.name=?, users.group=? where id=?;';
	$db_conn = $this->db_connect();
	if ($stmt = $db_conn->prepare($sql)) 
	{			
		$stmt->bind_param('sii',$uname,$group,$id);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	else 
	{
		$this->err_msg="db query error";
		return false;
	}
}
 }
?>