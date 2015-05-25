<?php
    include "./include/db_connect.php"; //$db_conn - var to db connect
	$query = "SELECT * FROM users" or die("Error in the consult.." . mysqli_error($db_conn)); //query
	$result = $db_conn->query($query);
    printf("<b>Users</b><br/><table border=1>");
    while($row = mysqli_fetch_array($result))
    {
        printf('
		<tr>
		<form>
		<td>
		<input type="text" value="'.$row["name"].'"/>
		</td><td>
		<input type="text" value="'.$row["group"].'"/>
		</td>
		</form>
		</tr>
		');
    } 
	printf("</table>");
		
?>