<a href="/news/add">Add news</a>
<?php 
$result=$this->model->get_short_news();
while($row = mysqli_fetch_array($result))
{
printf('
<div width="500px">
<a href="/news/full/'.$row["nid"].'">'.$row["name"].'</a><br/>
'.$row["short"].'<br/>
Author: '.$row["author"].'
</div>
<br/>
');
}
?>
