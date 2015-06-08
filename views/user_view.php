<?php
include '/views/fail_view.php';
?>
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