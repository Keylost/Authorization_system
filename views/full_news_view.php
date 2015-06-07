<?php
include '/views/fail_view.php'; // error check

$result=$this->model->get_full($this->model->news_id);
$result->bind_result($author_id,$author_name,$news_id,$news_name,$news_full,$news_short);/* result->variable */
if($result->fetch())
{
printf('
    <div style="border-width: 1px; border-style: solid;">
    <center><div class="alert alert-success" role="alert">'.$news_name.'</div></center>
    <div class="alert alert-info" role="alert">'.$news_full.'<br/>
	<hr>
	<b>Author:</b> '.$author_name.'<br/>
	<div class="btn-group btn-group-xs">
	');
	if($_SESSION['group']==1 || $_SESSION['user_id']==$author_id)
	{
		printf
		('  
			<form method="post" action="/news/edit" class="btn-group btn-group-xs">
			<input type="text" name="nid" value="'.$news_id.'" hidden/>
			<button type="submit" class="btn btn-warning" name="id" role="button">Edit</button>			
			</form>
			<form method="post" action="/news/delete" class="btn-group btn-group-xs">
			<input type="text" name="nid" value="'.$news_id.'" hidden/>
			<button type="submit" class="btn btn-danger" name="id" role="button">Delete</a>
			</form>
		');
	}
	printf('
	</div>
	</div>
	</div>
');
}
?>

