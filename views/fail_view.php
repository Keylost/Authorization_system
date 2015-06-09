<?php 
if(!empty($this->model->msg_type))
{
if($this->model->msg_type=='error')
{
printf('
<div class="alert alert-danger" role="alert">'.
$this->model->msg.'
</div>');
}
if($this->model->msg_type=='success')
{
printf('
<div class="alert alert-success" role="alert">'.
$this->model->msg.'
</div>');
}
}
?>