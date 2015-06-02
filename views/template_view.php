<?php $srv_root = "http://".$_SERVER['HTTP_HOST']."/";?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title> The troll bay </title>
</head>
<body>
    <img src="<?php printf($srv_root);?>img/1.png" align="right" style="position: absolute;left:50px"/>
    <img src="<?php printf($srv_root);?>img/2.png"  style="position:absolute;right:50px"/>
	
<p>
<h1 align="center">A SITE)</h1>
</p>
<br/><br/>
<h2>
<table border="1" width="100%">
<tr>
<td border="1"><a href="/">Main</a></td>
<td border="1"><a href="/about">About</a></td>
<td border="1"><a href="/admin">Admin panel</a></td>
</tr>
</table>
</h2>
    <?php include 'views/'.$content_view; ?>
</body>
</html>
