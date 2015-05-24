<?php 
require "include/auth.php";


ini_set('display_errors', 1);

if(isset($_GET['action']))
{
	if($_GET['action']=="logout")
	{
		session_destroy();
		header("Location: http://".$_SERVER['HTTP_HOST']."/");
		exit;
	}
}

if(!isset($_SESSION['user_id']))
{
printf('
<html>
<head><title>Sign In page</title></head>
<body>	
<script src="rollups/sha3.js"></script>
<script language="JavaScript">
function validForm(f) {
var hash = f.pass.value;
for (var i = 0; i < 23; i++) { //hash function, 23 rounds
hash = CryptoJS.SHA3(hash);
}
f.pass.value = hash;
f.submit(); //submit form
}
</script>

<form method="post" onSubmit="validForm(this); return false;" action="include/auth.php">
Login:  <input type="text" name="login"/><br/>
Password: <input type="password" name="pass"/><br/>
<input type="submit" value="Sign in" name="submit"/>
</form>');
printf("<br/>admin<br/>H6dW_kw852");
}
else printf("You already logged in!");

?>

<br/>
<h3><a href="reg.php">Registration</a></h3>
<h3><a href="index.php">Main page</a></h3>
</body>
</html>