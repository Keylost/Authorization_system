
	
	<div class="container-fluid">
	<div class="navbar-collapse collapse">
	<form class="navbar-form navbar-right" id="signform" method="post" action="/auth/signin">
    <input type="text" class="form-control" name="login"  placeholder="Login"/>
	<input type="password" name="pass" class="form-control" placeholder="Password"/>
	<div class="form-group"><input type="checkbox" checked class="form-control" id="sv" name="save"/><label for="sv">Remember Me </label>
	<br><a href="/auth/reset">Forgot Password?</a>
	</div>
	<button type="submit" class="btn btn-success btn-sm" form="signform" name="submit">Sign in</button>
	<a class="btn btn-danger btn-sm" href="/auth/registration" role="button">Registration</a>
    </form>
	</div>
	</div>	
	