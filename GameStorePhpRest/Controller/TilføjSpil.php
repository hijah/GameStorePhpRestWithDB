<?php

//twig
require_once '../vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../View');    //tells where the template is located
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('AlleSpil.html.twig');  //Refers to 'AlleSpil.html.twig so we can use the template

$Gam = new stdClass();  //Makes new class
$Gam ->Id = $_REQUEST['Id'];    //Sets Id with what we wrote in index
$Gam ->Title = $_REQUEST['Title'];  //Sets Title with what we wrote in index
$Gam ->Price = $_REQUEST['Price'];  //Sets Price with what we wrote in index
$Gam ->AntalPåLager = $_REQUEST['AntalPåLager'];    //Sets AntalPåLager with what we wrote in index

$json = json_encode($Gam);  //Encodes our class $Gam into json

// set up POST request
$URI = "http://wcfsoapservice.azurewebsites.net/Service1.svc/addgame";  // Uri for our AddGame service
$req = curl_init($URI); // initlize curl
curl_setopt($req, CURLOPT_CUSTOMREQUEST, "POST");   // request method
curl_setopt($req, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json)) // insert header i.e mime-type + length
);
curl_setopt($req, CURLOPT_POSTFIELDS, $json);   // insert data in body
curl_setopt($req, CURLOPT_RETURNTRANSFER, true);    // do not display json

$result = curl_exec($req);  // sends the request and get result

// Get All Games
$uri = "http://wcfsoapservice.azurewebsites.net/Service1.svc/games";    // Uri for our GetAllGames service
$jsonStr = file_get_contents($uri); //Puts the content of the request into $json
$Liste = json_decode($jsonStr); //Decodes the content so its readable


$twigContent = array("Game" => $Liste); // fill in the content for the page
echo $template->render($twigContent);   // let twig file generate html




