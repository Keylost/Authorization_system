<?php 
require "include/auth.php"; //session start(if user logged in)
?>
<html>
<head><title>Main page</title></head>
<body>
<br/>
<?php 
if(!isset($_SESSION['user_id']))
{
printf('	
<h3><a href="reg.php">Registration</a></h3>
<h3><a href="in.php">Sign In</a></h3>');
}
else printf('<h3><a href="in.php?action=logout">Log Off</a></h3>');
?>
</body>
</html>