
<?php 
include '/views/fail_view.php'; // error check

$result=$this->model->get_short_news();
$result->bind_result($author_id,$author_name,$news_id,$news_name,$news_short);/* result->variable */
while($result->fetch())
{
printf('
    <div style="border-width: 1px; border-style: solid;">
    <div class="alert alert-success" role="alert"><center>'.$news_name.'</center></div>	
    <div class="alert alert-info" role="alert">'.$news_short.'<br/>
	<hr>
	<b>Author:</b> '.$author_name.'<br/>
	<div class="btn-group btn-group-xs">
	<form method="post" action="/news/full" class="btn-group btn-group-xs">
	<input type="text" name="nid" value="'.$news_id.'" hidden/>
	<button type="submit" class="btn btn-success" name="id" role="button">Read</a>
	</form>
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
	<br/>
	');
}
?>
