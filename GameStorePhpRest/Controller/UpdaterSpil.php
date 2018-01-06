<?php

//twig
require_once '../vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../View');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('AlleSpil.html.twig');

$Game = new stdClass();
$Game ->Id = $_REQUEST['Id'];
$Game ->Title = $_REQUEST['Title'];
$Game ->Price = $_REQUEST['Price'];
$Game ->AntalPåLager = $_REQUEST['AntalPåLager'];

$json = json_encode($Game);

// set up PUT request
$URI = "http://wcfsoapservice.azurewebsites.net/Service1.svc/game";
$req = curl_init($URI); // initlize curl
curl_setopt($req, CURLOPT_CUSTOMREQUEST, "PUT");   // request method
curl_setopt($req, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json)) // insert header i.e mime-type + length
);
curl_setopt($req, CURLOPT_POSTFIELDS, $json);   // insert data in body
curl_setopt($req, CURLOPT_RETURNTRANSFER, true);    // do not display json

$result = curl_exec($req);  // sends the request and get result

// Get All Games
$uri = "http://wcfsoapservice.azurewebsites.net/Service1.svc/games";
$jsonStr = file_get_contents($uri);
$Liste = json_decode($jsonStr);


$twigContent = array("Game" => $Liste); // fill in the content for the page
echo $template->render($twigContent);   // let twig file generate html








