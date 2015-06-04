<?php
$result = $this->model->get_full($this->model->news_id);

if($row = mysqli_fetch_array($result))
{
?>
<form method="post" role="form" id="edit">
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php printf($row['name']); ?>"/>
  </div>
    <div class="form-group">
    <label for="short">Short description:</label>
    <textarea type="text" class="form-control" id="short" name="short"><?php printf($row['short']);?></textarea>
  </div>
  <div class="form-group">
    <label for="full">Full:</label>
    <textarea type="text" class="form-control" id="full" name="full"><?php printf($row['content']);?></textarea>
  </div>
<input name="id" value="<?php printf($row['nid']); ?>" hidden />
<button type="submit" class="btn btn-default" name="submit" form="edit">Submit</button>
</form>
<?php
}
else printf('Error');
?>
