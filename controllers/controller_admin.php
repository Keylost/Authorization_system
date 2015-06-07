<?php

class Controller_admin extends Controller
{
    function action_index()
    {
	if(!secure::check_rights(-1,'admin')) //check_rights
	{
		$this->view->generate('403_view.php','template_view.php');				
		exit;
	}
		
    if (isset($_POST['submit']))
    {
		if($_POST[delete_user]!='Yes')
		{
			$id = $_POST['uid'];
			$name = $_POST['uname'];
			$group = $_POST['group'];
			if($this->model->update_user($name,$group,$id)) 
			{
				$this->view->generate('success_view.php','template_view.php');
				exit;
			}
			else 
			{
				$this->view->generate('fail_view.php','template_view.php');
				exit;
			}
		}
		else 
		{
			if($this->model->delete_user($id)) 
			{
				$this->view->generate('success_view.php','template_view.php');
				exit;
			}
			else 
			{
				$this->view->generate('fail_view.php','template_view.php');
				exit;
			}
		}
    }
	
		if($_SESSION['group']==1) $this->view->generate('admin_view.php','template_view.php');
        else $this->view->generate('403_view.php','template_view.php');
    }
}
?>