<?php
if (isset($_REQUEST[session_name()])) session_start(); //session start(only if user logged in) required(php.ini): request_order = "GPC" (GET,POST,COOKIE)
if (isset($_SESSION['user_id'])) 
{
	if($_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) 
	{
		include "db_connect.php"; //$db_conn - var to db connect
		$query = "SELECT name FROM users WHERE id='".$_SESSION['user_id']."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
        $result = $db_conn->query($query); 
        if($row = mysqli_fetch_array($result)) //get first row from result or NULL
        {
           $login = $row["name"];
        } 
		else printf("DB connect error!");
		printf('
		<div style="position:absolute;right:180px;border:solid 1px black;">
		Hi, '.$login.' <(*_*)><br/>
		<a href="include/auth.php?action=sign_out">Sign Out</a>
		</div>
		');
		return;
    }
	else session_destroy();
}
else
{
	printf('	
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
<div style="position:absolute;right:180px;border:solid 1px black;">
<form method="post" onSubmit="validForm(this); return false;" action="include/auth.php">
Login:  <input type="text" name="login"/><br/>
Password: <input type="password" name="pass"/><br/>
<p><input type="submit" value="Sign in" name="submit"/> <a href="/registration">Registration</a></p>
</form>
admin H6dW_kw852
	</div>
	');
}
?>