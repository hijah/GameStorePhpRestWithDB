<?php

//twig
require_once '../vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../View');    //tells where the template is located
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('AlleSpil.html.twig');  //Refers to 'AlleSpil.html.twig so we can use the template

$id = $_REQUEST['Id'];  // Parameter we take from our index page

// set up DELETE request
$URI = "http://wcfsoapservice.azurewebsites.net/Service1.svc/game?id=".$id; // Uri for our DeleteGame service where we also add id
$req = curl_init($URI); // initlize curl
curl_setopt($req, CURLOPT_CUSTOMREQUEST, "DELETE");   // request method
curl_setopt($req, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'));

$result = curl_exec($req);  // sends the request and get result

//Get All
$uri = "http://wcfsoapservice.azurewebsites.net/Service1.svc/games";    // Uri for our GetAllGames service
$jsonStr = file_get_contents($uri); //Puts the content of the request into $json
$Liste = json_decode($jsonStr); //Decodes the content so its readable


$twigContent = array("Game" => $Liste); // fill in the content for the page
echo $template->render($twigContent);
