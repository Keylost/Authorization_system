<?php
class route_auth
{
static function start()
{
	//start session
	require_once '/controllers/controller_session.php';
	$session = new controller_session();
	$session->start();
}
}
?>