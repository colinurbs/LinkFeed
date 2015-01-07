<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();

// home
$app->get('/', function () use ($app) {
		$template = 
<<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>Slim Framework for PHP 5</title>
            <link type="text/css" rel="stylesheet" href="style.css">	
        <body>
        <div class="navbar">
        <a href="/new">New</a>
        </div>
        	<div class="container">
EOT;
        echo $template;
		$data = json_decode(file_get_contents("posts.json"));
	//print_r($data);
		echo "<div class=\"post\"><ul>";
		foreach($data as $post){
			echo "<li><h2><a href=\"".$post->link."\">".$post->link."</a></h2>";
			echo $post->comment."</li>";
		}
	echo "</ul></div>";
		$template = 
<<<EOT
			</div>
		</body>
	</html
EOT;
        echo $template;
});

//new item processing
$app->post('/new', function () use ($app) {
	$data = json_decode(file_get_contents("posts.json"));
	$data[] = array('link'=> $_POST['link'], 'comment'=> $_POST['comment']);
	$fp = fopen('posts.json', 'w');
	fwrite($fp, json_encode($data));
	fclose($fp);
	});

//insert test item, reset items
$app->get('/test', function () use ($app) {
	$post = array('link'=> "ThisIsALink", 'comment'=> "ThiIsAURL");
	$response[] = $post;
	$fp = fopen('posts.json', 'w');
	fwrite($fp, json_encode($response));
	fclose($fp);
	echo "File reset";
	die();
});

//new item form
$app->get('/new', function () use ($app) {
	$template = 
<<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>Slim Framework for PHP 5</title>
            <link type="text/css" rel="stylesheet" href="style.css">	
        <body>
        <div class="navbar">
        <a href="/new">New</a>
        </div>
        <div class="container">
	        <form action="/new" method ="post">
	           <label>Link</br><input id="link" name ="link" type="text"></input></label></br>
	            <label>Comment</br><input id="comment" name="comment" type="text"></input></label>
	            </br>
	            <input type="submit" value="Submit"/>
	         </form>
	     </div>
        </body>
    </html>
EOT;
        echo $template;
	});

$app->run();

?>