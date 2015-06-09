<?php
include '/views/fail_view.php';
?>
<hr/>
<a class="btn btn-danger" role="button" href="/auth/massignout">Close all my sessions</a>
<hr/>
<div class="h2">Change Password</div>
<div style="border-width: 1px; border-style: solid;">
<form method="post" role="form" id="reg" action="/user/changepass">
  <div class="form-group">
    <label for="old">Old password:</label>
    <input type="password" class="form-control" id="old" name="old_pass"/>
  </div>
  <div class="form-group">
    <label for="pwd">New Password:(min lenght: 8 symbols, max:20)</label>
    <input type="password" class="form-control" id="pwd" name="pass"/>
  </div>
    <div class="form-group">
    <label for="pwd2">Repeat Password:</label>
    <input type="password" class="form-control" id="pwd2" name="pass2"/>
  </div>
<button type="submit" class="btn btn-default" name="cnpwd" form="reg">Change Password</button>
</form>
</div>
<hr/>
<div class="h2">Change Email</div>
<div style="border-width: 1px; border-style: solid;">
<form method="post" role="form" id="cmail" action="/user/changemail">
    <div class="form-group">
    <label for="ml">New Email:</label>
    <input type="text" class="form-control" id="ml" name="mail"/>
  </div>
<button type="submit" class="btn btn-default" name="cnmail" form="cmail">Change Email</button>
</form>

</div>