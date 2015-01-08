<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8"/>
			<title>Slim Framework for PHP 5</title>
			<link type="text/css" rel="stylesheet" href="style.css">	
		<body>
		<div class="main-nav">
		<a href="/">Home</a>
		</div>
		<div class="container">
			<div class="post">
				<h2>New Post</h2>
				<form action="/new" method ="post">
				   <label>Link</br><input id="link" name ="link" type="text"></input></label></br>
					<label>Comment</br><input id="comment" name="comment" type="text"></input><span style="color:#ccc;"> optional</span></label>
					</br>
					<input type="submit" value="Submit"/>
				 </form>
			 </div>
		 </div>
		</body>
	</html>