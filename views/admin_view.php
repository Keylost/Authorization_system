
    <b>Users -//-
	<a href="/admin/groups"> Groups</a></b>
	<br/>
	<table class="table table-hover">
	<tr>
	<td>Name</td><td>Group</td><td>Delete?</td><td>Save</td>
	</tr>
	<?php
	$this->model->get_grouplist();
	$result = $this->model->get_users();
	$result->bind_result($uid,$uname,$gname,$gid);	
    while($result->fetch())
    {
        
		printf('
		<tr>
		<form method="post">
		<td>
		<input type="text" hidden name="uid" value="'.$uid.'"/>
		<input type="text" name="uname" value="'.$uname.'"/>
		</td>
		<td>
		<p><select name="group">
		');
        foreach($this->model->groups as $key => $value)
        {
           if($key==$gid) printf('<option selected value="'.$key.'">'.$value.'</option>');
		   else printf('<option value="'.$key.'">'.$value.'</option>');
        }
printf('		
        </select></p>
		</td>
		<td>
		<input type="checkbox" name="delete_user" value="Yes"/>
		</td>
		<td>
		<input type="submit" name=submit value="Save"/>
		</td>
		</form>
		</tr>
		');
			}
		?>
	</table>
		<?php include '/views/fail_view.php'; // error check ?>
