<?php
include '/views/fail_view.php';
?>
<div class="h2">Reset password</div>
<div style="border-width: 1px; border-style: solid;">
<form method="post" role="form" id="ccon" action="/auth/reset">
    <div class="form-group">
    <label for="ml">Enter your secret key:</label>
    <input type="text" class="form-control" id="ml" name="key"/>
  </div>
<button type="submit" class="btn btn-default" name="resetconf" form="ccon">Give me new pass</button>
</form>

</div>