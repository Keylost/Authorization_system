User already exist or db connect problem!
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