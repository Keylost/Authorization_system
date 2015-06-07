<?php include '/views/fail_view.php'; ?>
<form method="post" role="form" id="reg">
  <div class="form-group">
    <label for="login">Login:(min lenght: 3 symbols, max:20)</label>
    <input type="text" class="form-control" id="login" name="login"/>
  </div>
  <div class="form-group">
    <label for="pwd">Password:(min lenght: 8 symbols, max:20)</label>
    <input type="password" class="form-control" id="pwd" name="pass"/>
  </div>
    <div class="form-group">
    <label for="pwd2">Repeat Password:</label>
    <input type="password" class="form-control" id="pwd2" name="pass2"/>
  </div>
<button type="submit" class="btn btn-default" name="submit" form="reg">Submit</button>

</form>