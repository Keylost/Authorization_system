<?php
class View
{
    public $template_view='template_view.php'; // ����� ��� �� ���������.
    
    function generate($content_view,$template_view)
    {
        
        include 'views/'.$template_view;
    }
}
?>