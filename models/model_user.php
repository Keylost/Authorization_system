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
	public function changemail($id,$email)
	{
		$id = intval($id);
		if(!$this->mail_check($email)) return false;
		$db_conn = $this->db_connect();
		$sql = 'update users set users.mail=? where users.id=?';
		if($stmt=$db_conn->prepare($sql))
		{
			$stmt->bind_param('si',$email,$id);
			$res = $stmt->execute();
			$stmt->close();
			return 	$res;
		}
		return false;
	}
	private function mail_check($mail)
	{
		$email=mysql_real_escape_string($mail);
		// regular expression for email check
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
		if(preg_match($regex, $email))
		{
			return true;
		}
		else return false;
	}
}
?>