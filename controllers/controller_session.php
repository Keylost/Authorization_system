<?php
class controller_session extends Controller
{
    function start()
    {
		require_once '/core/model.php';
		$mdl = new model();
		$session = new db_session($mdl->db_connect());
		if(!empty($_COOKIE['session_id']))
		{
			$session->remind($_COOKIE['session_id']);			
		}
	}
}


class db_session
{
    private $db;
 
    public function __construct($db_connect_descriptor)
    {
        $this->db = $db_connect_descriptor;
    }
 
    public function remember($user_id, $expire = null)
    {
        $sql = 'INSERT INTO sessions (token, user_id, expire) VALUES (?, ?, ?)';
        $token = $this->generate_token($user_id,$expire);
        if($stmt = $this->db->prepare($sql))
		{
			$stmt->bind_param('sis',$token,$user_id,$expire);
			$stmt->execute();
			$stmt->close();
		}
 
        return $token;
    }
 
    public function remind($token)
    {
        $sql = 'SELECT users.id,users.name,users.group FROM sessions inner join users on users.id=sessions.user_id WHERE sessions.token =? AND (expire IS NULL OR expire <= NOW()) LIMIT 1';
        if($stmt = $this->db->prepare($sql))
		{
			$stmt->bind_param('s',$token);
			$stmt->execute();
			$stmt->bind_result($user_id,$user_name,$user_group);
			if($stmt->fetch()) 
			{
				$_SESSION["user_id"] = $user_id;
				$_SESSION["login"] = $user_name;
				$_SESSION["group"] = $user_group;
			}
			$stmt->close();
			return true;
		}

    }
	
	public function forget($token)
	{
		$sql = 'DELETE FROM sessions where token=?;';
		if($stmt = $this->db->prepare($sql))
		{
			$stmt->bind_param('s',$token);
			$stmt->execute();
			$stmt->close();
		}
	}
 
    private function generate_token($user_id,$expire)
    {
		$randbytes = openssl_random_pseudo_bytes(32, $cstrong);
		$token = $expire.$randbytes.$user_id;
		for($i=0; $i<10; $i++)
		{
			$token = hash('sha512', $token);
		}
		
		return $token;
  }
} 
?>