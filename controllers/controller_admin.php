<?php
require_once '/core/class_secure.php';
class Controller_admin extends Controller
{
    function action_index()
    {
    $this->view->set_model($this->model);		
    if (isset($_POST['submit']))
    {
		if($_POST[delete_user]!='Yes')
		{
			$id = secure::filter($_POST['uid']);
			$name = secure::filter($_POST['uname']);
			$group = secure::filter($_POST['group']);
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
			$id = secure::filter($_POST['uid']);
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