<html>
<head><title>Main page</title></head>
<body>

<form method="post">
Login:  <input type="text" name="login"/><br/>
Password: <input type="password" name="pass"/><br/>
<input type="submit" value="Sign in" name="submit"/>
</form>
<?php

ini_set('display_errors', 1);
$login = 'admin';
$passwd = '$6$UYBw1t0b7HaVgJjv$ZwTzevoXhrODZXpbZdMfixybNQJz37Cqe2GWCZRlKpaakMZUzEEhgRwqLvixJZJ6NZMolqiv1k15VkpHIuoG.0'; // H6dW_kw852

if (isset($_POST['submit']))
{
$salt = UYBw1t0b7HaVgJjv; //16 symbols salt
$hashed = crypt($_POST['pass'], '$6$'.$salt); //sha512, 5000 rounds

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
if (CRYPT_SHA512 == 1) {
    echo 'SHA-512:         ' . crypt('rasmuslerdorf', '$6$rounds=5000$usesomesillystringforsalt$') . "\n";
}
$salt = substr(str_shuffle("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345‌​6789"), 0, 16);
echo $salt;
//echo  phpversion();
*/
}

printf("<br/>admin<br/>H6dW_kw852")
?>
</body>
</html>