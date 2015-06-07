<?php 
if(!empty($this->model->err_msg))
{
printf('
<div class="alert alert-danger" role="alert">'.
$this->model->err_msg.'
</div>');
}
?>