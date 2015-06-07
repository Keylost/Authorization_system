<?php
include '/views/fail_view.php'; // error check

$result=$this->model->get_full($this->model->news_id);
$result->bind_result($author_id,$author_name,$news_id,$news_name,$news_full,$news_short);/* result->variable */
if($result->fetch())
{
?>
<form method="post" role="form" id="edit">
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php printf($news_name); ?>"/>
  </div>
    <div class="form-group">
    <label for="short">Short description:</label>
    <textarea type="text" class="form-control" id="short" name="short"><?php printf($news_short);?></textarea>
  </div>
  <div class="form-group">
    <label for="full">Full:</label>
    <textarea type="text" class="form-control" id="full" name="full"><?php printf($news_full);?></textarea>
  </div>
<input name="nid" value="<?php printf($news_id); ?>" hidden />
<button type="submit" class="btn btn-default" name="submit" form="edit">Submit</button>
</form>
<?php
}
else printf($result->error);
?>
