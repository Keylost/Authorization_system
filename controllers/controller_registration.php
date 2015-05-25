<?php
class Controller_registration extends Controller
{
    function action_index()
    {	
        $this->view->generate('registration_view.php','template_view.php');
    }
}
?>