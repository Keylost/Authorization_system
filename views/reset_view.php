<?php
include '/views/fail_view.php';
?>
<div class="h2">Reset password</div>
<div style="border-width: 1px; border-style: solid;">
<form method="post" role="form" id="cmail" action="/auth/reset">
    <div class="form-group">
    <label for="ml">Your Email:</label>
    <input type="text" class="form-control" id="ml" name="mail"/>
  </div>
<button type="submit" class="btn btn-default" name="reset" form="cmail">Reset</button>
</form>

</div>