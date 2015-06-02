<?php
class model_auth extends model
{
	public $salt;
	public $passwd;
	public $id;
	public $group;
    function get_user($login)
    {	
include "/core/db_connect.php"; //$db_conn - var to db connect
$query = "SELECT * FROM users WHERE name='".$login."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
$result = $db_conn->query($query); 
if($row = mysqli_fetch_array($result)) //get first row from result or NULL
{
  $this->salt = $row["salt"];
  $this->passwd = $row["password"];
  $this->id = $row["id"];
  $this->group = $row["group"];
  return true;
}
else return false; 
    }
	function add_user($login,$pass,$salt)
	{
		include "/core/db_connect.php"; //$db_conn - var to db connect
		$query = "INSERT INTO users VALUES ('', '".$login."', '".$pass."', DEFAULT, '".$salt."');" or die("Error in the consult.." . mysqli_error($db_conn)); //query
        $result = $db_conn->query($query);
		return $result;
	}	
}
?>