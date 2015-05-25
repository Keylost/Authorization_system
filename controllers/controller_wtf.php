<?php
class Controller_Wtf extends Controller
{
    function action_index()
    {	
        $this->view->generate('wtf_view.php','template_view.php');
    }
}
?>