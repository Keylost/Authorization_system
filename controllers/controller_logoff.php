<?php
class Controller_logoff extends Controller
{
    function action_index()
    {	
        //session_start();
		session_destroy();
		header("Location: http://".$_SERVER['HTTP_HOST']."/");
		exit;
    }
}
?>