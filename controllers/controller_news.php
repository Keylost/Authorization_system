<?php
class Controller_news extends Controller
{
    function action_delete()
    {	
	    include "./include/db_connect.php"; //$db_conn - var to db connect
		$query = "SELECT * FROM groups WHERE id='".$_SESSION['group']."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
		$result = $db_conn->query($query); 
        if($row = mysqli_fetch_array($result)) //get first row from result or NULL
        {
           $delete = $row["delete"];
        } 
		if($delete) $this->view->generate('news_del_view.php','template_view.php');
        else $this->view->generate('403_view.php','template_view.php');
    }
	    function action_read()
    {	
	    include "./include/db_connect.php"; //$db_conn - var to db connect
		$query = "SELECT * FROM groups WHERE id='".$_SESSION['group']."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
        $result = $db_conn->query($query); 
        if($row = mysqli_fetch_array($result)) //get first row from result or NULL
        {
           $read = $row["read"];
        } 
		if($read) $this->view->generate('news_read_view.php','template_view.php');
        else $this->view->generate('403_view.php','template_view.php');
    }
	    function action_edit()
    {	
	    include "./include/db_connect.php"; //$db_conn - var to db connect
		$query = "SELECT * FROM groups WHERE id='".$_SESSION['group']."'" or die("Error in the consult.." . mysqli_error($db_conn)); //query
        $result = $db_conn->query($query); 
        if($row = mysqli_fetch_array($result)) //get first row from result or NULL
        {
           $edit = $row["edit"];
        } 
		if($edit) $this->view->generate('news_edit_view.php','template_view.php');
        else $this->view->generate('403_view.php','template_view.php');
    }
}
?>