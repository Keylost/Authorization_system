<?php
class controller_session extends Controller
{
    function start()
    {
if (isset($_REQUEST[session_name()])) session_start(); //session start(only if user logged in) required(php.ini): request_order = "GPC" (GET,POST,COOKIE)
if (isset($_SESSION['user_id'])) 
{
	if($_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) 
	{
		//$login = $this->model->get_user($_SESSION['user_id']);
		$this->view->include_block('usermenu_view.php');
		return;
    }
	else session_destroy();
}
else
{
	$this->view->include_block('signmenu_view.php');
}
	}
}
?>