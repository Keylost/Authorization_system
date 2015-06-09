<?php


class controller_session extends Controller
{
    private $db;
	private $session_time;
	private $nor_time;
	public $view;
 
    public function __construct()
    {
		include '/core/session.conf';
		require_once '/core/view.php';
		$this->view = new view();
		$this->session_time = $session_time;
		$this->nor_time= $no_remember_time;
        require_once '/core/model.php';
		$mdl = new model();
		$this->db = $mdl->db_connect();
    }
	
    function start()
    {
		if(!empty($_COOKIE['session_id'])&&!empty($_COOKIE['series_id']))
		{
			$this->remind($_COOKIE['session_id'],$_COOKIE['series_id']);			
		}
		$this->cleaner();
	}
	function cleaner()
	{
		//session cleaner
		include '/core/session.conf';
		$db = $this->db;
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
	
 
    public function remember($user_id, $expire = null)
    {
        $expiredb = 0;
		$remember = 0;
		if($expire!=null) 
		{
			$expiredb = time()+$this->session_time;
			$expire = $expiredb;
			$remember = 1;
		}
		else
		{
			$expiredb = time()+$this->nor_time;
		}
		$sql = 'INSERT INTO sessions (token, user_id, expire,series,remember) VALUES (?, ?, ?,?,?)';
        $token = $this->generate_token($user_id,$expiredb);
		$series = $this->generate_token(rand(0,5000),rand(0,5000));
        if($stmt = $this->db->prepare($sql))
		{
			$stmt->bind_param('siisi',$token,$user_id,$expiredb,$series,$remember);
			$stmt->execute();
			$stmt->close();
		}
		setcookie('session_id', $token, $expire,'/');
		setcookie('series_id', $series, $expire,'/');
        return true;;
    }
 
    public function remind($token,$series)
    {
		$now =time();
        $sql = 'SELECT users.id,users.name,users.group,sessions.token,sessions.remember,sessions.expire FROM sessions inner join users on users.id=sessions.user_id WHERE sessions.series =? AND expire >? LIMIT 1';
        if($stmt = $this->db->prepare($sql))
		{
			$stmt->bind_param('si',$series,$now);
			$stmt->execute();
			$stmt->bind_result($user_id,$user_name,$user_group,$current_token,$remember,$expire);
			$stmt->fetch();
			$stmt->close();
			if($token!=$current_token)
				{
					$sql2 = 'delete from sessions where user_id=?;';
					$stmt2 = $this->db->prepare($sql2);
					$stmt2->bind_param('i',$user_id);
					$stmt2->execute();
					$stmt2->close();
					setcookie('session_id', $series, $now-3600,'/'); //unset cookie
					setcookie('series_id', $series, $now-3600,'/'); //unset cookie
				}
			else
				{
					$sql2 = 'update sessions set token=?,expire=? where series=?;';
					if($remember)
					{
						$expire= time()+ $this->session_time;
					}
					$token2 = $this->generate_token($user_id,$expire);
					$stmt2 = $this->db->prepare($sql2);
					$stmt2->bind_param('sis',$token2,$expire,$series);
					$stmt2->execute();
					$stmt2->close();
					$_SESSION["user_id"] = $user_id;
					$_SESSION["login"] = $user_name;
					$_SESSION["group"] = $user_group;
					setcookie('session_id', $token2, $expire,'/');
				}			
			
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