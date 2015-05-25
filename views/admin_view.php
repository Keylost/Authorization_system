<?php
    include "./include/db_connect.php"; //$db_conn - var to db connect
    if (isset($_POST['submit']))
    {
	    include "./include/secure.php";
		if($_POST[delete_user]!='Yes')
		{
			$query = 'update users set users.name="'.$_POST[uname].'", users.group="'.$_POST[group].'" where id="'.$_POST[uid].'"' or die("Error in the consult.." . mysqli_error($db_conn));
			if(!$db_conn->query($query)) printf("Error!");
		}
		else 
		{
			$query = 'delete from users where id="'.$_POST[uid].'"' or die("Error in the consult.." . mysqli_error($db_conn));
			if(!$db_conn->query($query)) printf("Error!");
		}
    }

    
	$query = "SELECT groups.id as gid, groups.name as gname FROM groups" or die("Error in the consult.." . mysqli_error($db_conn)); //query
	$groupslist = $db_conn->query($query);
    while($row2 = mysqli_fetch_array($groupslist))
	{
		$gid["$row2[gid]"] = $row2[gname];
	}

	$query = "SELECT users.id as uid, users.name as uname, groups.name as gname, groups.id as gid FROM users inner join groups on users.group=groups.id" or die("Error in the consult.." . mysqli_error($db_conn)); //query
	$result = $db_conn->query($query);
    printf("<b>Users</b><br/><table border=1>
	<tr>
	<td>Name</td><td>Group</td><td>Delete?</td><td>Save</td>
	</tr>
	");
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
        foreach($gid as $key => $value)
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
		<input type="submit" name=submit value="Save"
		</td>
		</form>
		</tr>
		');
    } 
	printf("</table>");
		
?>