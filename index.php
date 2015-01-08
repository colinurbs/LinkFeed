<?php
require 'vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

$app = new \Slim\Slim(array(
    'templates.path' => './templates'
));

// home
$app->get('/', function () use ($app) {
		$data = json_decode(file_get_contents("posts.json"));
		$app->render('home.php', array('posts' => $data));
})->name("home");

//new item processing
$app->post('/new', function () use ($app) {
	$data = json_decode(file_get_contents("posts.json"));

	$doc = new DOMDocument();
	@$doc->loadHTMLFile($_POST['link']);
	$xpath = new DOMXPath($doc);
	$title = $xpath->query('//title')->item(0)->nodeValue."\n";
	
	$meta = get_meta_tags ($_POST['link']);

	if (!isset($meta['description'])){
		$meta['description']="";
	}
	$data[] = array('link'=> $_POST['link'], 'comment'=> $_POST['comment'], 'title'=> $title, 'description' =>$meta['description']);
	$fp = fopen('posts.json', 'w');
	fwrite($fp, json_encode($data));
	fclose($fp);
	$app->response->redirect($app->urlFor('home'), 303);
	});

//delete
$app->get('/delete/:$link', function ($link) use ($app) {
	echo $link;
	$data = json_decode(file_get_contents("posts.json"));
	//$app->render('admin.php', array('posts' => $data));
});

//admin view
$app->get('/admin', function () use ($app) {
	$data = json_decode(file_get_contents("posts.json"));
	$app->render('admin.php', array('posts' => $data));
});

//new item form
$app->get('/new', function () use ($app) {
$app->render('new.php');
});

$app->run();
?>