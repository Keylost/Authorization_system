<?php
class Controller_admin extends Controller
{
    function action_index()
    {	
        include "./include/db_connect.php"; //$db_conn - var to db connect
		$query = "SELECT * FROM groups WHERE id='".$_SESSION['group']."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
		$result = $db_conn->query($query); 
        if($row = mysqli_fetch_array($result)) //get first row from result or NULL
        {
           $group = $row["name"];
        } 
		if($group=='admins') $this->view->generate('admin_view.php','template_view.php');
        else $this->view->generate('403_view.php','template_view.php');
    }
}
?>