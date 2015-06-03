
<?php 
$result=$this->model->get_short_news();
while($row = mysqli_fetch_array($result))
{
printf('
    <div style="border-width: 1px; border-style: solid;">
    <div class="alert alert-success" role="alert"><center>'.$row["name"].'</center></div>	
    <div class="alert alert-info" role="alert">'.$row["short"].'<br/>
	<hr>
	<b>Author:</b> '.$row["author"].'<br/>
	<div class="btn-group btn-group-xs">
	<a class="btn btn-success" href="/news/full/'.$row["nid"].'" role="button">Read</a>
	');
	if($_SESSION['group']==1 || $_SESSION['user_id']==$row["uid"])
	{
		printf
		('
			<a class="btn btn-warning" href="/news/edit/'.$row["nid"].'" role="button">Edit</a>
			<a class="btn btn-danger" href="/news/delete/'.$row["nid"].'" role="button">Delete</a>
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
