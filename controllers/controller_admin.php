<?php

class Controller_admin extends Controller
{
    function action_index()
    {
	if(!secure::check_rights('admin')) //check_rights
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
	
	$this->view->generate('admin_view.php','template_view.php');
    }
	
	public function action_groups()
	{
		if(!secure::check_rights('admin')) //check_rights
		{
			$this->view->generate('403_view.php','template_view.php');				
			exit;
		}
		$this->model->group=$_SESSION['group'];
		if(isset($_POST['select']))
		{
			if(!empty($_POST['group'])) $this->model->group = intval($_POST['group']);
		}
		
		if(isset($_POST['save']))
		{
			if(!empty($_POST['act_id']) && !empty($_POST['gr_id']))
			{
				if(isset($_POST['access'])) $_POST['access'] = 1;
				else $_POST['access'] = 0;
				$this->model->group = intval($_POST['gr_id']);
				if($this->model->set_permissions($_POST['act_id'],$_POST['gr_id'],$_POST['access']))
				{
					$this->model->msg_type='success';
					$this->model->msg = 'update success';
				}
				else
				{
					$this->model->msg_type='error';
					$this->model->msg = 'data base record update error';
				}
			}
		}
		
		if(isset($_POST['gcreate']))
		{
			if(!empty($_POST['gname']))
			{
				if($this->model->create_group($_POST['gname']))
				{
					$this->model->msg_type='success';
					$this->model->msg = 'created!';
				}
				else
				{
					$this->model->msg_type='error';
					$this->model->msg = 'data base record insert error';
				}
			}
		}
		
		if(isset($_POST['cdelete']))
		{
			if(!empty($_POST['gid']))
			{
				if($this->model->group_delete($_POST['gid']))
				{
					$this->model->msg_type='success';
					$this->model->msg = 'deleted!';
				}
				else
				{
					$this->model->msg_type='error';
					$this->model->msg = 'data base record delete error';
				}					
			}			
		}
		
		if(isset($_POST['acreate']))
		{
			if(!empty($_POST['aname']))
			{
				if($this->model->create_action($_POST['aname']))
				{
					$this->model->msg_type='success';
					$this->model->msg = 'deleted!';
				}
				else
				{
					$this->model->msg_type='error';
					$this->model->msg = 'data base record delete error';
				}					
			}			
		}
		
		$this->view->generate('group_control_view.php','template_view.php');		
		exit();
	}

	public function action_deletegroup()
	{
		if(!secure::check_rights('admin')) //check_rights
		{
			$this->view->generate('403_view.php','template_view.php');				
			exit;
		}
		if(isset($_POST['gdelete']))
		{
			if(!empty($_POST['gid']))
			{
				$this->model->group = intval($_POST['gid']);
				$this->view->generate('groupdelete_view.php','template_view.php');
				exit();	
			}
		}

		$this->view->generate('group_control_view.php','template_view.php');
		exit();
	}
	
}
?>