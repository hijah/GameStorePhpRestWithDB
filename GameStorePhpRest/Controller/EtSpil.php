<?php

//twig
require_once '../vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../View');    //tells where the template is located
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('EtSpil.html.twig');    //Refers to 'AlleSpil.html.twig so we can use the template

$id = $_REQUEST['ID'];  // Parameter we take from our index page

$uri = "http://wcfsoapservice.azurewebsites.net/Service1.svc/game/".$id;    // Uri for our GetOneGame service where we also add id
$json = file_get_contents($uri);    //Puts the content of the request into $json
$Game = json_decode($json); //Decodes the content so its readable

$twigContent = array("Game" => $Game); // fill in the content for the page
echo $template->render($twigContent);