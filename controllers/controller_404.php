<?php
class Controller_404 extends Controller
{
    function action_index()
    {	
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found"); 
        $this->view->generate('404_view.php','template_view.php');
    }
}
?>