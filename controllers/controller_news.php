<?php
require_once "/core/class_secure.php";
class Controller_news extends Controller
{
	function action_edit()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if(isset($_POST['submit']))
		{
			if(empty($_POST['name']) || empty($_POST['short']) || empty($_POST['full']) || empty($_POST['id'])) //null check
			{				
				$this->view->generate('fail_view.php','template_view.php');				
				exit;
			}
			$id = secure::filter($_POST['id']);
			$name = secure::filter($_POST['name']);
			$short = secure::filter($_POST['short']);
			$full = secure::filter($_POST['full']);
			$result = $this->model->get_author($id);
			$author = -1;
			if($row = mysqli_fetch_array($result)) //get first row from result or NULL
			{
				$author = $row["author"];
			}
            if(secure::check_rights($author,'edit'))
			{
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
				$this->view->generate('403_view.php','template_view.php');
				exit;
			}	
		}		
		else if(!empty($routes[3]))
		{	
			$id = secure::filter($routes[3]);
			$this->view->set_model($this->model);
			$this->model->news_id=$id;
			$this->view->generate('edit_news_view.php','template_view.php');
			exit;
		}
		else
		{
			$this->view->generate('404_view.php','template_view.php');
			exit;
		}
	}
    function action_delete()
    {	
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if(!empty($routes[3]))
		{
			$id = secure::filter($routes[3]);
            $result = $this->model->get_author($id);
			$author = -1;
			if($row = mysqli_fetch_array($result)) //get first row from result or NULL
			{
				$author = $row["author"];
			}
            if(secure::check_rights($author,'delete'))
			{
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
				$this->view->generate('403_view.php','template_view.php');
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
		$this->view->set_model($this->model);
		$this->view->generate('short_news_view.php','template_view.php');
		exit;
	}
	function action_add()
	{
		if (isset($_POST['submit']))
		{
			if(empty($_POST['name']) || empty($_POST['short']) || empty($_POST['full'])) //null check
			{				
				$this->view->generate('fail_view.php','template_view.php');				
				exit;
			}
			$name = secure::filter($_POST['name']);
			$author=$_SESSION['user_id'];
			if(!secure::check_rights($author,'add_news')) //check_rights
			{
				$this->view->generate('fail_view.php','template_view.php');				
				exit;
			}
			$short_content = secure::filter($_POST['short']);
			$content = secure::filter($_POST['full']);
			if($this->model->add_news($author,$name,$short_content,$content))
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