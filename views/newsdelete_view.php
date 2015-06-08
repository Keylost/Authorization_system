Are you sure?
<form action="/news/delconfirmed" method="post">
<input type="text" name="nid" value="<?php printf($this->model->news_id); ?>" hidden />
<p>
<input type="submit" name="cdelete" value="Delete this news" class="btn btn-default" role="button"/>
<a href="<?php printf(getenv("HTTP_REFERER")); ?>" class="btn btn-default" role="button">No....</a>
</p>
</form>
