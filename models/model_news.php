<?php
class model_news extends model
{
	public $news_id;
	function delete_news($id)
	{		
		include "/core/db_connect.php"; //$db_conn - var to db connect
	    $query = 'delete from news where id="'.$id.'"' or die("Error in the consult.." . mysqli_error($db_conn));
	    if(!$db_conn->query($query)) return false;
	    else return true;
	}
	function get_short_news()
	{
		include '/core/db_connect.php'; //$db_conn - var to db connect
		$query = "SELECT users.id as uid, users.name as author, news.id as nid, news.name as name, news.short_content as short FROM users inner join news on users.id=news.author" or die("Error in the consult.." . mysqli_error($db_conn)); //query
		$result = $db_conn->query($query);
		return $result;
	}
	function get_full($id)
	{
		include '/core/db_connect.php'; //$db_conn - var to db connect
		$query = "SELECT users.id as uid, users.name as author, news.name as name, news.content as content FROM users inner join news on users.id=news.author where news.id=".$id."" or die("Error in the consult.." . mysqli_error($db_conn)); //query
		$result = $db_conn->query($query);
		return $result;
	}
	function add_news($author,$name,$short_content,$content)
	{
		include '/core/db_connect.php';
		$query = "INSERT INTO news VALUES ('', '".$author."', '".$name."', '".$content."', '".$short_content."');" or die("Error in the consult.." . mysqli_error($db_conn)); //query
        $result = $db_conn->query($query);
		return $result;
	}
	function get_author($news_id)
	{
		include '/core/db_connect.php';
		$query = "SELECT author as uid FROM news WHERE news.id=".$news_id.";" or die("Error in the consult.." . mysqli_error($db_conn)); //query
        $result = $db_conn->query($query);
		return $result;
	}
}
?>