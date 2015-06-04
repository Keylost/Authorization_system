<?php $srv_root = "http://".$_SERVER['HTTP_HOST']."/";?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title> The troll bay </title>
</head>
<body>
<div class="container">
    <img src="<?php printf($srv_root);?>img/1.png" align="right" style="position: absolute;left:50px"/>
    <img src="<?php printf($srv_root);?>img/2.png"  style="position:absolute;right:50px"/>
	
<p>
<h1 align="center">A SITE)</h1>
</p>
<br/><br/>
<nav class="navbar navbar-default">
    <ul class="nav navbar-nav">
        <li><a href="/">Main</a></li>
        <?php if(isset($_SESSION['user_id'])) printf('<li><a href="/news/add">Add news</a></li>'); ?>
        <?php if($_SESSION['group']==1) printf('<li><a href="/admin">Admin panel</a></li>'); ?>
		<li><a href="/about">About</a></li>
    </ul>
	<?php
	if (isset($_SESSION['user_id']))
	{	
		include 'views/usermenu_view.php';
	}
	else include 'views/signmenu_view.php';
	?>
</nav>
<?php

include 'views/'.$content_view;

?>
</div>
</body>
</html>
