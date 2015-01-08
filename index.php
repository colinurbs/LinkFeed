<?php
require 'vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

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
		
		foreach($data as $post){
			echo "<div class=\"post\">";
			echo "<h2><a href=\"".$post->link."\">".$post->title."</a></h2>";
			echo "<p>".$post->description."</p>";
			echo $post->comment;
			echo "</div>";
		}
	
		$template = 
<<<EOT
			</div>
		</body>
	</html
EOT;
		echo $template;
})->name("home");;

//new item processing
$app->post('/new', function () use ($app) {
	$data = json_decode(file_get_contents("posts.json"));

	$doc = new DOMDocument();
	@$doc->loadHTMLFile($_POST['link']);
	$xpath = new DOMXPath($doc);
	$title = $xpath->query('//title')->item(0)->nodeValue."\n";
	//use Sunra\PhpSimple\HtmlDomParser;
	$meta = get_meta_tags ($_POST['link']);

	// if (!isset($meta['description'])){
	// 	$meta['description']="";
	// }

	error_log(print_r($meta,true));
	$data[] = array('link'=> $_POST['link'], 'comment'=> $_POST['comment'], 'title'=> $title, 'description' =>$meta['description']);
	$fp = fopen('posts.json', 'w');
	fwrite($fp, json_encode($data));
	fclose($fp);
	$app->response->redirect($app->urlFor('home'), 303);
	});

//insert test item, reset items
$app->get('/test', function () use ($app) {
	$post = array('link'=> "ThisIsALink", 'comment'=> "ThiIsAURL",'title'=> "meta_title", 'description' =>"meta_description");
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
		<div class="main-nav">
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