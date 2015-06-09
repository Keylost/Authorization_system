<?php

class controller_auth extends controller
{
function action_reset()
{
	$this->view->generate('reset_view.php','template_view.php');
}	
	
	
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
	$session = new controller_session();
	if(isset($_POST['save'])) //remember
	{
		$session->remember($id,1);
	}
	else //don't remember
	{
		$session->remember($id,NULL);
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
		$session = new controller_session();
		$session->forget($_COOKIE['session_id']);
		setcookie('session_id', $_COOKIE['session_id'], time()-3600,'/'); 
		header("Location: http://".$_SERVER['HTTP_HOST']."/");
		exit;
	}
	
	function action_massignout()
	{
		$session = new controller_session();
		$session->forget_all($_SESSION['user_id']);
		setcookie('session_id', $_COOKIE['session_id'], time()-3600,'/'); 
		header("Location: http://".$_SERVER['HTTP_HOST']."/");
		exit;
	}
	
	function action_registration()
	{
		if (isset($_POST['submit']))
			{
				if(empty($_POST['login'])||empty($_POST['pass'])||empty($_POST['pass2'])||empty($_POST['mail'])) //null check
				{
					$this->model->err_msg = 'All fields are required!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;	
				}
				$paslen = strlen($_POST['pass']);
				$loglen = strlen($_POST['login']);
				if($paslen<8||$loglen<3)
				{
					$this->model->err_msg = 'Password or login too short!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;					
				}
				if($paslen>20||$loglen>20)
				{
					$this->model->err_msg = 'Password or login too long!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;					
				}
				if(!$this->mail_check($_POST['mail']))
				{
					$this->model->err_msg = 'Incorrect email address!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;	
				}

				if($_POST['pass']!=$_POST['pass2'])
				{
					$this->model->err_msg = 'Passwords don\'t match!';
					$this->view->generate('registration_view.php','template_view.php');
					exit;					
				}
				$salt = $this->generate_salt();
				$hashed = $_POST['pass'].$salt;
				for($i=0; $i<2171; $i++)
				{
					$hashed = hash('sha512', $hashed);
				}
				
				$login = secure::filter($_POST['login']);
				if(!$this->model->add_user($login,$hashed,$salt,$_POST['mail'])) //$result=true if success
				{
					$this->model->err_msg = 'Error user creating!';
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

	private function generate_salt()
	{
    $salt = openssl_random_pseudo_bytes(20, $cstrong);
    return $salt;
	}
	private function mail_check($mail)
	{
		$email=mysql_real_escape_string($mail);
		// regular expression for email check
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
		if(preg_match($regex, $email))
		{
			return true;
		}
		else return false;
	}
	
}

?>