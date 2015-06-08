Are you sure?
<form action="/admin/groups" method="post">
<input type="text" name="gid" value="<?php printf($this->model->group); ?>" hidden />
<p>
<input type="submit" name="cdelete" value="Delete this group"/>
<a href="/admin/groups">No....</a>
</p>
</form>
