<?php

class controller_auth extends controller
{
function action_signin()
{
if (isset($_POST['submit']))
{
if(empty($_POST['login'])||empty($_POST['pass'])) //null check
{
	$this->model->err_msg = 'All fields are required!';
	$this->view->generate('fail_view.php','template_view.php');
	exit;	
}
$login = $_POST['login'];
if(!$this->model->get_user($login))
{	
	$this->model->err_msg = 'Password or login incorrect!<br/>Try<br/>admin H6dW_kw852';
	$this->view->generate('fail_view.php','template_view.php');
	exit;
}
$salt = $this->model->salt;
$id = $this->model->id;
$group = $this->model->group;
$passwd = $this->model->passwd;

$hashed = $_POST['pass'].$salt;
for($i=0; $i<2171; $i++)
{
	$hashed = hash('sha512', $hashed);
}

//if(hash_equals($passwd,$hashed)) //minimum required: php 5.6 Timing attack safe string comparison
if($passwd == $hashed && $login==$_POST['login'])
{
	$mdl = new model();
	$session = new db_session($mdl->db_connect());
	if(isset($_POST['save'])) //remember
	{
		$day = date('d');
		$month = date('m');
		$year = date('Y');
		if($month==12) 
		{
			$month = 1;
			$year = $year+1;
		}
		else $month =$month+1;
		$expire = mktime(0,0,0,$month,$day,$year); //h:min:sec:month,day,year //1 month
		$token = $session->remember($id,$expire);
		setcookie('session_id', $token, $expire,'/'); 
	}
	else //don't remember
	{
		$expire = time() + 60*20; //20 minutes
		$token = $session->remember($id,$expire);
		setcookie('session_id', $token, $expire,'/');
	}	
	header("Location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
else
{
	$this->model->err_msg = 'Password or login incorrect!<br/>Try<br/>admin H6dW_kw852';
	$this->view->generate('fail_view.php','template_view.php');
	exit;
}
}
	}
	
	function action_signout()
	{
		session_start();
		session_destroy();
		header("Location: http://".$_SERVER['HTTP_HOST']."/");
		exit;
	}
	
	function action_registration()
	{
		if (isset($_POST['submit']))
			{
				if(empty($_POST['login'])||empty($_POST['pass'])||empty($_POST['pass2'])) //null check
				{
					$this->model->err_msg = 'All fields are required!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;	
				}
				if(strlen($_POST['pass'])<8||strlen($_POST['login'])<3)
				{
					$this->model->err_msg = 'Password or login too short!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;					
				}
				if(strlen($_POST['pass'])>20||strlen($_POST['login'])>20)
				{
					$this->model->err_msg = 'Password or login too long!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;					
				}	
				if($_POST['pass']!=$_POST['pass2'])
				{
					$this->model->err_msg = 'Passwords don\'t match!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;					
				}
				$salt = substr(str_shuffle("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_"), 0, 16);//16 symbols random salt	
				$hashed = $_POST['pass'].$salt;
				for($i=0; $i<2171; $i++)
				{
					$hashed = hash('sha512', $hashed);
				}
				$login = secure::filter($_POST['login']);
				if(!$this->model->add_user($login,$hashed,$salt)) //$result=true if success
				{
					$this->model->err_msg = 'User already exist!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;
				} 
				else
				{
					$this->view->generate('success_view.php','template_view.php');
					exit;
				}
			}
		else
		{
			$this->view->generate('registration_view.php','template_view.php');
			exit;
		}
	}
}

?>