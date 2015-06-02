<?php
$db_host = "127.0.0.1";
$db_user = "KGB";
$db_pass = "1234";
$db_name = "KGB";

$db_conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name) or die("Error " . mysqli_error($db_conn)); //mysql_connect is unsafe
?>