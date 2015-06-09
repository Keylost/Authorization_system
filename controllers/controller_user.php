<?php
class controller_user extends controller
{	
	public function action_index()
	{
		if(!isset($_SESSION['user_id']))
		{
			$this->view->generate('403_view.php','template_view.php');
			exit;
		}
		$this->view->generate('user_view.php','template_view.php');
		$exit;
	}
	
	public function action_changepass()
	{
		if(!isset($_SESSION['user_id']))
		{
			$this->view->generate('403_view.php','template_view.php');
			exit;
		}
		if(isset($_POST['cnpwd']))
		{
			if(empty($_POST['pass'])||empty($_POST['pass2'])||empty($_POST['old_pass']))
			{
				$this->model->err_msg = 'All fields are required!';
				$this->view->generate('user_view.php','template_view.php');
				exit;	
			}
			if(strlen($_POST['pass'])<8)
			{
				$this->model->err_msg = 'Password or login too short!';
				$this->view->generate('user_view.php','template_view.php');
				exit;					
			}
			if(strlen($_POST['pass'])>20)
			{
				$this->model->err_msg = 'Password or login too long!';
				$this->view->generate('user_view.php','template_view.php');
				exit;					
			}	
			if($_POST['pass']!=$_POST['pass2'])
			{
				$this->model->err_msg = 'Passwords don\'t match!';
				$this->view->generate('user_view.php','template_view.php');
				exit;					
			}
			$id = $_SESSION['user_id'];
			$salt = $this->generate_salt();
			$hashed = $_POST['pass'].$salt;
			for($i=0; $i<2171; $i++)
			{
				$hashed = hash('sha512', $hashed);
			}
			$user_info=$this->model->get_user($id);
			if(!$user_info)
			{	
				$this->model->err_msg = 'Internal system error';
				$this->view->generate('user_view.php','template_view.php');
				exit;
			}
			$old_hash = $user_info['pass'];
			$check_old = $_POST['old_pass'].$user_info['salt'];
			for($i=0; $i<2171; $i++)
			{
				$check_old = hash('sha512', $check_old);
			}
			if($check_old==$old_hash)
			{
				$this->model->update($id,$hashed,$salt);
				$this->view->generate('success_view.php','template_view.php');
				exit;
			}
			else
			{
				$this->model->err_msg = 'Old password incorrect!';
				$this->view->generate('user_view.php','template_view.php');
				exit;
			}
		}
	}
	private function generate_salt()
	{
		$salt = openssl_random_pseudo_bytes(20, $cstrong);
		return $salt;
	}
}
?>