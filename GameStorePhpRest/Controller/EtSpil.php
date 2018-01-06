<?php

require_once '../vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../View');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('EtSpil.html.twig');

$id = $_REQUEST['ID'];

$uri = "http://wcfsoapservice.azurewebsites.net/Service1.svc/game/".$id;
$json = file_get_contents($uri);
$Game = json_decode($json);

$twigContent = array("Game" => $Game); // fill in the content for the page
echo $template->render($twigContent);