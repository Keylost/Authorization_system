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
		return;
    }
	else session_destroy();
}
	}
}
?>