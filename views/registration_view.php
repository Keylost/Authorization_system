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

<form method="post" onSubmit="validForm(this); return false;" role="form" id="reg">
  <div class="form-group">
    <label for="login">Login:</label>
    <input type="text" class="form-control" id="login" name="login"/>
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd" name="pass"/>
  </div>
    <div class="form-group">
    <label for="pwd2">Repeat Password:</label>
    <input type="password" class="form-control" id="pwd2" name="pass2"/>
  </div>
<button type="submit" class="btn btn-default" name="submit" form="reg">Submit</button>

</form>