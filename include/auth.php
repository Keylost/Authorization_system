<?php
if (isset($_POST['submit']))
{
include "db_connect.php"; //$db_conn - var to db connect
include "secure.php"; //filter($str)

$login = filter($_POST['login']);
$query = "SELECT * FROM users WHERE name='".$login."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
$result = $db_conn->query($query); 
if($row = mysqli_fetch_array($result)) //get first row from result or NULL
{
  $salt = $row["salt"];
  $passwd = $row["password"];
  $id = $row["id"];
  $group = $row["group"];
} 

$hashed = $_POST['pass'].$salt;
for($i=0; $i<2171; $i++)
{
	$hashed = hash('sha512', $hashed);
}

//if(hash_equals($passwd,$hashed)) //minimum required: php 5.6 Timing attack safe string comparison
if($passwd == $hashed && $login==$_POST['login'])
{
	session_start();
	$_SESSION['user_id'] = $id;
	$_SESSION['group'] = $group;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR']; //save user ip and id
	header("Location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
else
{
	printf("Password or login incorrect");
}
}
if(isset($_GET['action']))
{
	if($_GET['action']=='sign_out')
	{
		session_start();
		session_destroy();
		header("Location: http://".$_SERVER['HTTP_HOST']."/");
		exit;
	}
}
?>