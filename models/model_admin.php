 <?php
require_once '/core/class_secure.php';
 class model_admin extends model
 {
public $group;
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

function get_permissions($group_id)
{
	$id = intval($group_id);
	$db = $this->db_connect();
	$sql = "SELECT permissions.access,actions.action,permissions.action_id,permissions.group_id FROM permissions inner join actions on actions.id=permissions.action_id WHERE permissions.group_id=?;";
	$stmt=$db->prepare($sql);
	$stmt->bind_param('i',$id);
	$stmt->execute();
	return $stmt;
	
} 
 
function set_permissions($action_id,$group_id,$access)
{
	$gid = intval($group_id);
	$aid = intval($action_id);
	$access = intval($access);
	$db = $this->db_connect();
	$sql = 'update permissions set access=? where (group_id=? and action_id=?);';
	$stmt=$db->prepare($sql);
	$stmt->bind_param('iii',$access,$gid,$aid);
	$res = $stmt->execute();
	$stmt->close();
	return $res;
}
 
function create_group($gname)
{
	$gname = secure::filter($gname);
	$db = $this->db_connect();
	$sql = "insert into groups values('',?);";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('s',$gname);
	$stmt->execute();
	$group_id = $db->insert_id;
	$this->group = $group_id;
	$stmt->close;
	$act = array();
	$sql = 'select id from actions;';
	$stmt= $db->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($aid);
	$i=0;
	while($stmt->fetch())
	{
		$act[$i] = $aid;
		$i = $i+1;
	}
	$stmt->close();
	$sql = 'insert into permissions values(?,?,0)';
	$stmt = $db->prepare($sql);
	while($i>0)
	{
		$i= $i-1;
		$action_id = $act[$i];
		$stmt->bind_param('ii',$group_id,$action_id);
		$stmt->execute();
		
	}
	$stmt->close();
	return true;
}

function group_delete($group_id)
{
	$group_id=intval($group_id);
	$db = $this->db_connect();
	$sql = "delete from groups where id=?;";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i',$group_id);
	$res1 = $stmt->execute();
	$stmt->close();
	$db = $this->db_connect();
	$sql = "delete from permissions where group_id=?;";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i',$group_id);
	$res2 = $stmt->execute();
	$stmt->close();
	$db = $this->db_connect();
	$sql = "delete from users where group=?;";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('i',$group_id);
	$res3 = $stmt->execute();
	$stmt->close();
	if($res1 && $res2 && $res3) return true;
	else return false;
}

function create_action($aname)
{
	$aname = secure::filter($aname);
	$db = $this->db_connect();
	$sql = "insert into actions values('',?);";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('s',$aname);
	$stmt->execute();
	$action_id = $db->insert_id;
	$stmt->close;
	$grp = array();
	$sql = 'select id from groups;';
	$stmt= $db->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($gid);
	$i=0;
	while($stmt->fetch())
	{
		$grp[$i] = $gid;
		$i = $i+1;
	}
	$stmt->close();
	$sql = 'insert into permissions values(?,?,0)';
	$stmt = $db->prepare($sql);
	while($i>0)
	{
		$i= $i-1;
		$group_id = $grp[$i];
		$stmt->bind_param('ii',$group_id,$action_id);
		$stmt->execute();
		
	}
	$stmt->close();
	return true;
}
 }
?>