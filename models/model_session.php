<?php
class model_session extends model
{
    function get_user($id)
    {	
        include '/core/db_connect.php';
		$query = "SELECT name FROM users WHERE id='".$id."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
        $result = $db_conn->query($query); 
        if($row = mysqli_fetch_array($result)) //get first row from result or NULL
        {
           $login = $row["name"];
        } 
		else printf("DB connect error!");
		return $login;
    }
}
?>