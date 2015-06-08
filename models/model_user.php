<?php
class model_user extends model
{
	public function get_user($id)
	{		
		$id = intval($id);
		$db_conn = $this->db_connect();
		$sql = 'SELECT users.salt,users.password FROM users WHERE id=?';
		if($stmt=$db_conn->prepare($sql))
		{
			$stmt->bind_param('i',$id);
			$stmt->execute();
			$stmt->bind_result($salt,$pass);
			$stmt->fetch();
			$user_info = array("salt"=>$salt,"pass"=>$pass);
			$stmt->close();
			return $user_info;
		}
		return false;
	}
	public function update($id,$hashed,$salt)
	{
		$id = intval($id);
		$db_conn = $this->db_connect();
		$sql = 'update users set users.password=?,users.salt=? where users.id=?';
		if($stmt=$db_conn->prepare($sql))
		{
			$stmt->bind_param('ssi',$hashed,$salt,$id);
			$res = $stmt->execute();
			$stmt->close();
			return 	$res;
		}
		return false;
	}
}
?>