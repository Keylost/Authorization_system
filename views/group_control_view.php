<?php
$this->model->get_grouplist();
$gid = $this->model->group;;
?>
    <b><a href="/admin">Users</a> -//-
	 Groups</b>
	<br/>
<form method="post">
<p>
<input type="text" name="gname" value="New group"/>
<input type="submit" name="gcreate" value="Create new group"/>
</p>
</form>

<form method="post">
<p><select name="group">
<?php
    foreach($this->model->groups as $key => $value)
    {
        if($key==$gid) printf('<option selected value="'.$key.'">'.$value.'</option>');
		else printf('<option value="'.$key.'">'.$value.'</option>');
    }
?>	
</select>
<input type="submit" name="select" value="Select"/></p>
</form>

<form action="/admin/deletegroup" method="post">
<input type="text" name="gid" value="<?php printf($gid); ?>" hidden />
<input type="submit" name="gdelete" value="Delete this group"/>
</form>

<table class="table table-hover">
<tr>
<td>Action</td><td>Access</td>
</tr>
<?php
$stmt = $this->model->get_permissions($gid);
$stmt->bind_result($access,$action,$act_id,$gr_id);
while($stmt->fetch())
{
	?>
	
	<tr>
	<form method="post">
	<td><?php printf($action); ?></td>
	<?php if($access) printf('<td><input type="checkbox" name="access" value="'.$access.'" checked/></td>');
	else printf('<td><input type="checkbox" name="access" value="'.$access.'"/></td>'); ?>
	<td><input type="text" hidden name="act_id" value="<?php printf($act_id); ?>"/>
	<input type="text" hidden name="gr_id" value="<?php printf($gr_id); ?>"/></td>
	<td><input type="submit" name="save" value="save"/></td>	
	</form>
	</tr>
	
	<?php
}
$stmt->close();

?>
</table>
<form method="post">
<p>
<input type="text" name="aname" value="New action"/>
<input type="submit" name="acreate" value="Create new action"/>
</p>
</form>

	<?php include '/views/fail_view.php'; // error check ?>