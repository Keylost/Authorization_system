<?php
class Controller_403 extends Controller
{
    function action_index()
    {	
		header('HTTP/1.1 403 Forbidden');
		header("Status: 403 Forbidden"); 
        $this->view->generate('403_view.php','template_view.php');
    }
}
?>