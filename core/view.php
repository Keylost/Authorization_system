<?php
class View
{
    public $template_view='template_view.php'; // ����� ��� �� ���������.
	public $model;
    
    function generate($content_view,$template_view)
    {
        include 'views/'.$template_view;
    }
}
?>