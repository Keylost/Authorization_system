<?php
function filter($str) //filter function
{
$str = strip_tags($str);	
$str = htmlspecialchars($str);
$str = mysql_escape_string($str);
return $str;	
}
?>