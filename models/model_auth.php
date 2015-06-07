<?php
require_once "/core/class_secure.php";
class model_auth extends model
{
	public $salt;
	public $passwd;
	public $id;
	public $group;
function get_user($login)
{	
$login = secure::filter($_POST['login']);
$sql = "SELECT users.id,users.password,users.salt,users.group FROM users WHERE name=?;"; //query
$db_conn = $this->db_connect();
if ($stmt = $db_conn->prepare($sql)) 
	{
		$stmt->bind_param('s', $login);				
		$stmt->execute();
	}
	else 
	{
		$this->err_msg="db query error";
		return false;
	}
$stmt->bind_result($user_id,$pass,$salt,$group);
if($stmt->fetch()) //get first row from result or NULL
{
  $this->salt = $salt;
  $this->passwd = $pass;
  $this->id = $user_id;
  $this->group = $group;
  return true;
}
else return false; 
}

	function add_user($login,$pass,$salt)
	{	
		$login = secure::filter($login);
		$db_conn = $this->db_connect();
		$sql = "INSERT INTO users VALUES ('', ?, ?, DEFAULT, ?);"; //query
		if ($stmt = $db_conn->prepare($sql)) 
		{
			$stmt->bind_param('sss', $login,$pass,$salt);				
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