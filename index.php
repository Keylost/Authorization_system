<html>
<head><title>Main page</title></head>
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
<form method="post" onSubmit="validForm(this); return false">
Login:  <input type="text" name="login"/><br/>
Password: <input type="password" name="pass"/><br/>
<input type="submit" value="Sign in" name="submit"/>
</form>
<?php

ini_set('display_errors', 1);

if (isset($_POST['submit']))
{
include "include/db_connect.php"; //$db_conn - var to db connect
include "include/secure.php"; //filter($str)

$login = filter($_POST['login']);
$query = "SELECT password,salt FROM users WHERE name='".$login."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
$result = $db_conn->query($query); 
if($row = mysqli_fetch_array($result)) //get first row from result or NULL
{
  $salt = $row["salt"];
  $passwd = $row["password"];
} 

$hashed = $_POST['pass'].$salt;
for($i=0; $i<2171; $i++)
{
	$hashed = hash('sha512', $hashed);
}

//if(hash_equals($passwd,$hashed)) //minimum required: php 5.6 Timing attack safe string comparison
if($passwd == $hashed && $login==$_POST['login'])
{
	printf("Hi <(*_*)>");
}
else
{
	printf("Password or login incorrect");
}

}

printf("<br/>admin<br/>H6dW_kw852");
?>

<br/>
<h3><a href="reg.php">Registration</a></h3>
</body>
</html>