<?php
class View
{
    public $template_view='template_view.php'; // ����� ��� �� ���������.
	public $model;
	
	function set_model($model)
	{
		$this->model= $model;
	}
    
    function generate($content_view,$template_view)
    {
        include 'views/'.$template_view;
    }
	function include_block($block)
	{
		include 'views/'.$block;
	}
}
?>