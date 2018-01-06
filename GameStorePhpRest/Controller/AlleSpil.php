<?php

require_once "../vendor/autoload.php";
Twig_Autoloader::register();

//$loader er en variable med navnet "loader"
$loader = new Twig_Loader_Filesystem('../View');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('AlleSpil.html.twig');

$uri = "http://wcfsoapservice.azurewebsites.net/Service1.svc/games";
$json = file_get_contents($uri);
$Liste = json_decode($json);

$twigContent = array("Game" => $Liste); // fill in the content for the page
#print_r($twigContent);
echo $template->render($twigContent);




