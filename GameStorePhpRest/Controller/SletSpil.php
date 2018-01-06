<?php

// Twig
require_once '../vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../View');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('AlleSpil.html.twig');

$id = $_REQUEST['Id'];

// set up DELETE request
$URI = "http://wcfsoapservice.azurewebsites.net/Service1.svc/game?id=".$id;
$req = curl_init($URI); // initlize curl
curl_setopt($req, CURLOPT_CUSTOMREQUEST, "DELETE");   // request method
curl_setopt($req, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'));

$result = curl_exec($req);  // sends the request and get result

//Get All
$uri = "http://wcfsoapservice.azurewebsites.net/Service1.svc/games";
$jsonStr = file_get_contents($uri);
$Liste = json_decode($jsonStr);


$twigContent = array("Game" => $Liste); // fill in the content for the page
echo $template->render($twigContent);   // let twig file generate html


//http://wcfsoapservice.azurewebsites.net/Service1.svc/game?id={ID}