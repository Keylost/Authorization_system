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
		//session cleaner
		include '/core/session.conf';
		$db = $mdl->db_connect();
		$sql = "select time from cron where action='session';";
		$stmt= $db->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($tm);
		$stmt->fetch();
		$last=$tm;
		$stmt->close();
		$now = time();
		if(($now-$last)>$cron_time)
		{		
			$sql = 'delete from sessions where expire<?';
			$stmt = $db->prepare($sql);
			$stmt->bind_param('i',$now);
			$stmt->execute();
			$stmt->close();
			$sql = "update cron set time=? where action='session';";
			$stmt = $db->prepare($sql);
			$stmt->bind_param('i',$now);
			$stmt->execute();
			$stmt->close();
		}
	}
}


class db_session
{
    private $db;
	private $session_time;
	private $nor_time;
 
    public function __construct($db_connect_descriptor)
    {
		include '/core/session.conf';
		$this->session_time = $session_time;
		$this->nor_time= $no_remember_time;
        $this->db = $db_connect_descriptor;
    }
 
    public function remember($user_id, $expire = null)
    {
        $expiredb = 0;
		if($expire!=null) 
		{
			$expiredb = time()+$this->session_time;
			$expire = $expiredb;
		}
		else
		{
			$expiredb = time()+$this->nor_time;
		}
		$sql = 'INSERT INTO sessions (token, user_id, expire) VALUES (?, ?, ?)';
        $token = $this->generate_token($user_id,$expiredb);
        if($stmt = $this->db->prepare($sql))
		{
			$stmt->bind_param('sis',$token,$user_id,$expiredb);
			$stmt->execute();
			$stmt->close();
		}
		setcookie('session_id', $token, $expire,'/');
        return true;;
    }
 
    public function remind($token)
    {
		$now =time();
        $sql = 'SELECT users.id,users.name,users.group FROM sessions inner join users on users.id=sessions.user_id WHERE sessions.token =? AND expire >? LIMIT 1';
        if($stmt = $this->db->prepare($sql))
		{
			$stmt->bind_param('si',$token,$now);
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
	
	public function forget_all($user_id)
	{
		$id = intval($user_id);
		$sql = 'DELETE FROM sessions where user_id=?;';
		if($stmt = $this->db->prepare($sql))
		{
			$stmt->bind_param('i',$id);
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