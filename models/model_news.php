<?php
//require_once "/core/class_secure.php";
class model_news extends Model
{
	public $news_id;
	function edit_news($id,$name,$short,$full)
	{
		$id = intval($id);	
		$name = secure::filter($name);
		$short = secure::filter($short);
		$full = secure::filter($full);
		$db_conn = $this->db_connect();
		$sql = 'update news set name=?,short_content=?,content=? where id=?;';
        if ($stmt = $db_conn->prepare($sql)) 
		{
			$stmt->bind_param('sssi',$name,$short,$full,$id);
			//echo $name.$short.$full.$id;
			$result = $stmt->execute();
			return $result;
		}
		else 
		{
			$this->err_msg="db query error";
			return false;
		}
	}
	function delete_news($id)
	{		
		$id = intval($id);
		$db_conn = $this->db_connect();
	    $sql = "DELETE FROM news WHERE id=?;";
	    if ($stmt = $db_conn->prepare($sql)) 
		{
			$stmt->bind_param('i', $id);
			$result = $stmt->execute();
			$stmt->close();
			return result;
		}
		else 
		{
			$this->err_msg="db query error";
			return false;
		}
	}
	function get_short_news()
	{
		$db_conn = $this->db_connect();
		$sql = "SELECT users.id as uid, users.name as author, news.id as nid, news.name as name, news.short_content as short FROM users inner join news on users.id=news.author ORDER BY news.id DESC;";
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
	function get_full($id)
	{
		$db_conn = $this->db_connect();
		$sql = "SELECT users.id, users.name, news.id, news.name, news.content, news.short_content FROM users inner join news on users.id=news.author where news.id=?;";
		$id = intval($id);		
		if ($stmt = $db_conn->prepare($sql)) 
		{
			$stmt->bind_param('i', $id);
			$stmt->execute();
			return $stmt;
		}
		else 
		{
			$this->err_msg="db query error";
			return false;
		}
	}
	function add_news($author_id,$name,$short,$full)
	{
		$id = intval($author_id);		
		$name = secure::filter($name);
		$short = secure::filter($short);
		$full = secure::filter($full);
		
		$db_conn = $this->db_connect();
		$sql = 'INSERT INTO news(id,author,name,content,short_content) VALUES (0, ?, ?, ?, ?);';
        if ($stmt = $db_conn->prepare($sql)) 
		{
			$stmt->bind_param('isss', $id,$name,$full,$short);
			$result = $stmt->execute();
			return $result;
		}
		else 
		{
			$this->err_msg="db query error";
			return false;
		}
	}
	function get_author($news_id)
	{
		$id = intval($news_id);
		$db_conn = $this->db_connect();
		$sql = "SELECT author FROM news WHERE news.id=?;";
        if ($stmt = $db_conn->prepare($sql)) 
		{
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->bind_result($aid);
			$author = -1;
			If($stmt->fetch()) //get first row from result or NULL
			{
				$author = $aid;
			}
			$stmt->close;
			return $author;
		}
		else 
		{
			$this->err_msg="db query error";
			return false;
		}
	}
}
?>