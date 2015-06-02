
    <b>Users</b><br/><table border=1>
	<tr>
	<td>Name</td><td>Group</td><td>Delete?</td><td>Save</td>
	</tr>
	<?php
	$result = $this->model->get_users();
	$this->model->get_grouplist();
    while($row = mysqli_fetch_array($result))
    {
        
		printf('
		<tr>
		<form method="post">
		<td>
		<input type="text" hidden name="uid" value="'.$row["uid"].'"/>
		<input type="text" name="uname" value="'.$row["uname"].'"/>
		</td>
		<td>
		<p><select name="group">
		');
        foreach($this->model->groups as $key => $value)
        {
           if($key==$row[gid]) printf('<option selected value="'.$key.'">'.$value.'</option>');
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
		
