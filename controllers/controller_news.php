<?php
require_once "/core/class_secure.php";
class Controller_news extends Controller
{
    function action_delete()
    {	
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if(!empty($routes[3]))
		{
			$id = secure::filter($routes[3]);
            $result = $this->model->get_author($id);
			if($row = mysqli_fetch_array($result)) //get first row from result or NULL
			{
				$author = $row["author"];
			}
            if(secure::check_rights($author,'delete'))
			{
				if($this->model->delete_news($id))
				{
					$this->view->generate('delete_news_success_view.php','template_view.php');
				    exit;
				}
				else
				{
					$this->view->generate('delete_news_fail_view.php','template_view.php');
					exit;
				}	
			}
            else
			{
				$this->view->generate('403_view.php','template_view.php');
				exit;
			}				
			
			$this->view->set_model($this->model);
		}
		else
		{
			$this->view->generate('404_view.php','template_view.php');
			exit;
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
	function action_index()
	{		
		$this->view->set_model($this->model);
		$this->view->generate('short_news_view.php','template_view.php');
		exit;
	}
	function action_add()
	{
		if (isset($_POST['submit']))
		{
			$name = secure::filter($_POST['name']);
			$author=$_SESSION['user_id'];
			$short_content = secure::filter($_POST['short']);
			$content = secure::filter($_POST['full']);
			if($this->model->add_news($author,$name,$short_content,$content))
			{
				$this->view->generate('add_news_success_view.php','template_view.php');
				exit;
			}
			else
			{
				$this->view->generate('add_news_fail_view.php','template_view.php');
				exit;
			}
		}
		else
		{
			$this->view->generate('add_news_view.php','template_view.php');
		}
	}
	function action_full()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if(!empty($routes[3]))
		{
			$id = secure::filter($routes[3]);			
			$this->model->news_id = $id;
			$this->view->set_model($this->model);
			$this->view->generate('full_news_view.php','template_view.php');
			exit;
		}
		else
		{
			$this->view->generate('404_view.php','template_view.php');
			exit;
		}
	}
}
?>