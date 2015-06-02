<?php
class route_auth
{
static function start()
{
$routes = explode('/', $_SERVER['REQUEST_URI']);
// получаем имя контроллера
if ( !empty($routes[1]) && $routes[1]=='auth' )
{	
    //routes: [1] - controller; 2 - action
		if (!empty($routes[2]) )
		{
            $action = 'action_'.$routes[2];
			require_once '/controllers/controller_auth.php';
			require_once '/models/model_auth.php';
			$controller = new controller_auth();
			$controller->model = new model_auth();
			if(method_exists($controller, $action))
			{
				$controller->$action();
			}
			else
			{
				// отсутствует нужный метод
				header('Location: http://'.$_SERVER['HTTP_HOST'].'/'.'404');
				exit;
			}	
		}
}
else
{
	//start session
	require_once '/controllers/controller_session.php';
	require_once '/models/model_session.php';
	$session = new controller_session();
	$session->model = new model_session();
	$session->start();

}
}
}
?>