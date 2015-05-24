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
$login = 'admin';
$passwd = '5700031f6bc1d32ab5a0df04708560138b33526e386073beabdfa9699ae1152e802f9712e9659b3b6e3c6f497e7a11c57b46ccd673051d1cffeb9f35936c6450'; // H6dW_kw852
$salt = UYBw1t0b7HaVgJjv; //16 symbols salt

if (isset($_POST['submit']))
{
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

/*
$salt = substr(str_shuffle("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345‌​6789"), 0, 16);
*/
}

//printf("<br/>".$hashed);
printf("<br/>admin<br/>H6dW_kw852");
?>
</body>
</html>