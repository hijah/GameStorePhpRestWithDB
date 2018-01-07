<?php

//twig
require_once "../vendor/autoload.php";
Twig_Autoloader::register();

//$loader er en variable med navnet "loader"
$loader = new Twig_Loader_Filesystem('../View');    //tells where the template is located
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('AlleSpil.html.twig');  //Refers to 'AlleSpil.html.twig so we can use the template

//GetAllGames Service
$uri = "http://wcfsoapservice.azurewebsites.net/Service1.svc/games"; // Uri for our GetAllGames service
$json = file_get_contents($uri); //Puts the content of the request into $json
$Liste = json_decode($json); //Decodes the content so its readable


$twigContent = array("Game" => $Liste); // fill in the content for the page
#print_r($twigContent);
echo $template->render($twigContent);




