   <script language="JavaScript">
    function validForm(f) {
    f.submit(); //submit form
    }
    </script>
<div style="position:absolute;right:180px;top:20px;border:solid 1px black;">
<form method="post" onSubmit="validForm(this); return false;" action="/auth/signin">
Login:  <input type="text" name="login"/><br/>
Password: <input type="password" name="pass"/><br/>
<p><input type="submit" value="Sign in" name="submit"/> <a href="/auth/registration">Registration</a></p>
</form>
admin H6dW_kw852
	</div>