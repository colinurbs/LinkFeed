<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8"/>
			<title>Slim Framework for PHP 5</title>
			<link type="text/css" rel="stylesheet" href="style.css">	
		<body>
		<div class="main-nav">
		<a href="/new">New</a>
		</div>
		<div class="container">
		<?php
				foreach($posts as $post){
				echo "<div class=\"post\">";
				echo "<h2><a href=\"".$post->link."\">".$post->title."</a></h2>";
				echo "<p>".$post->description."</p>";
				echo $post->comment;
				echo "</div>";
			}
		
		?>
		 </div>
		</body>
	</html>