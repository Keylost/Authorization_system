<?php
$result = $this->model->get_full($this->model->news_id);
if($row = mysqli_fetch_array($result))
{
printf('
    <div style="border-width: 1px; border-style: solid;">
    <center><div class="alert alert-success" role="alert">'.$row["name"].'</div></center>
    <div class="alert alert-info" role="alert">'.$row["content"].'<br/>
	<hr>
	<b>Author:</b> '.$row["author"].'<br/>
	<div class="btn-group btn-group-sm">
	');
	if($_SESSION['group']==1 || $_SESSION['user_id']==$row["uid"])
	{
		printf
		('
			<a class="btn btn-warning" href="/news/edit/'.$this->model->news_id.'" role="button">Edit</a>
			<a class="btn btn-danger" href="/news/delete/'.$this->model->news_id.'" role="button">Delete</a>
		');
	}
	printf('
	</div>
	</div>
	</div>
');
}
?>

