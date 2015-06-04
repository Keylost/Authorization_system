<?php
require_once "/core/class_secure.php";
class controller_auth extends controller
{
	function action_signin()
	{
if (isset($_POST['submit']))
{
$login = secure::filter($_POST['login']);
if(!$this->model->get_user($login))
{	
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
	session_start();
	$_SESSION['user_id'] = $id;
	$_SESSION['login'] = $login;
	$_SESSION['group'] = $group;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR']; //save user ip and id
	header("Location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
else
{
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
				$salt = substr(str_shuffle("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_"), 0, 16);//16 symbols random salt	
				$hashed = $_POST['pass'].$salt;
				for($i=0; $i<2171; $i++)
				{
					$hashed = hash('sha512', $hashed);
				}
				$login = secure::filter($_POST['login']);
				if(!$this->model->add_user($login,$hashed,$salt)) //$result=true if success
				{
					$this->view->generate('fail_view.php','template_view.php');
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