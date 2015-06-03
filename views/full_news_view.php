<?php
$result = $this->model->get_full($this->model->news_id);
if($row = mysqli_fetch_array($result))
{
printf('
<div width="500px">
'.$row["name"].'<br/>
'.$row["content"].'<br/>
Author: '.$row["author"].'
</div>
<br/><br/>
');
}
?>