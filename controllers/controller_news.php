<?php
require_once "/core/class_secure.php";
class Controller_news extends Controller
{
	function action_edit()
	{
		if(isset($_POST['nid']))
		{
			$id = $_POST['nid'];
			if(empty($id))
			{
				$this->view->generate('404_view.php','template_view.php');
				exit;
			}
			if($result = $this->model->get_author($id)) //get first row from result or NULL
			{
				$author = $result;
			}
		}
		if(!secure::check_rights($author,'edit'))
		{
			echo $author;
			$this->view->generate('403_view.php','template_view.php');		
			exit;				
		}
		if(isset($_POST['submit']))
		{
			if(empty($_POST['name']) || empty($_POST['short']) || empty($_POST['full']) || empty($_POST['nid'])) //null check
			{				
				$this->view->generate('fail_view.php','template_view.php');				
				exit;
			}
			$name = $_POST['name'];
			$short = $_POST['short'];
			$full = $_POST['full'];
			$id = $_POST['nid'];
				if($this->model->edit_news($id,$name,$short,$full))
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
			$this->model->news_id=$id;
			$this->view->generate('edit_news_view.php','template_view.php');
			exit;
		}
	}
    function action_delete()
    {
		if(isset($_POST['id']))
		{
			$id = $_POST['nid'];
			if(empty($id))
			{
				$this->view->generate('404_view.php','template_view.php');
				exit;
			}
			if($result = $this->model->get_author($id)) //get first row from result or NULL
			{
				$author = $result;
			}

			if(!secure::check_rights($author,'delete'))
			{
				$this->view->generate('403_view.php','template_view.php');
				exit;
			}
			if($this->model->delete_news($id))
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
			$this->view->generate('404_view.php','template_view.php');
			exit;
		}
    }

	function action_index()
	{		
		$this->view->generate('short_news_view.php','template_view.php');
		exit;
	}
	function action_add()
	{
		$author = -1;
		if(!empty($_SESSION['user_id'])) $author=$_SESSION['user_id'];
		if(!secure::check_rights($author,'add_news')) //check_rights
		{
			$this->view->generate('403_view.php','template_view.php');				
			exit;
		}
		
		if (isset($_POST['submit']))
		{
			if(empty($_POST['name']) || empty($_POST['short']) || empty($_POST['full'])) //null check
			{				
				$this->view->generate('fail_view.php','template_view.php');				
				exit;
			}
						
			if($this->model->add_news($author,$_POST['name'],$_POST['short'],$_POST['full']))
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
			$this->view->generate('add_news_view.php','template_view.php');
		}
	}
	function action_full()
	{
		if(isset($_POST['id']))
		{
			$id = $_POST['nid'];
			if(empty($id))
			{
				$this->view->generate('404_view.php','template_view.php');
				exit;
			}			
			$this->model->news_id = $id;
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