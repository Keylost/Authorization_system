<?php
class View
{
    public $template_view='template_view.php'; // общий вид по умолчанию.
    
    function generate($content_view,$template_view)
    {
        
        include 'views/'.$template_view;
    }
}
?>