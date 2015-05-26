<script src="rollups/sha3.js"></script>
<script language="JavaScript">
function validForm(f) 
{
if (f.pass.value != f.pass2.value) 
{
alert("Passwords don't match!");
return false;
}
else
{
	if(f.login.value.length<3 || f.pass.value.length<8)
	{
		alert('Password or login are too short!');
		return false;
	}
	else
	{
		var hash = f.pass.value;
        for (var i = 0; i < 23; i++) //hash function, 23 rounds
		{ 
        hash = CryptoJS.SHA3(hash);
        }
        f.pass.value = hash;
		f.pass2.value = 0;
        f.submit(); //submit form
    }
}
}
</script>

<form method="post" onSubmit="validForm(this); return false;">
Login:  <input type="text" name="login"/><br/>
Password: <input type="password" name="pass"/><br/>
Repeat password: <input type="password" name="pass2"/><br/>
<input type="submit" value="Submit" name="submit"/>
</form>

<?php
ini_set('display_errors', 1);
if (isset($_POST['submit']))
{
include "include/db_connect.php"; //$db_conn - var to db connect
include "include/secure.php"; //filter($str)
	
$salt = substr(str_shuffle("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_"), 0, 16);//16 symbols random salt	
$hashed = $_POST['pass'].$salt;
for($i=0; $i<2171; $i++)
{
	$hashed = hash('sha512', $hashed);
}
$login = filter($_POST['login']);
$query = "INSERT INTO users VALUES ('', '".$login."', '".$hashed."', DEFAULT, '".$salt."');" or die("Error in the consult.." . mysqli_error($db_conn)); //query
$result = $db_conn->query($query);
if(!$result) //$result=true if success
{
  printf("This user already exist or db connect problem");
} 
else printf("<script language='JavaScript'>document.location.href = 'http://".$_SERVER['HTTP_HOST']."/';</script>");
}

?>