<?php
use app\DefaultApp\DefaultApp as app;
try {
//inclure autoload
    require "../vendor/autoload.php";
////inclure la configuration
    require "../app/DefaultApp/configuration.php";

////instancier une nouvelle application
    new \app\DefaultApp\DefaultApp($configuration);
////inclure les diferents route definit dans app/Routing.php
    \app\DefaultApp\DefaultApp::routing();
////on demarre l'application
    \app\DefaultApp\DefaultApp::run();
}Catch(Exception $exception) {

?>

                                <a onclick="history.back(-1)" href="#">Go Back</a>
                                <a href="<?= \app\DefaultApp\DefaultApp::genererUrl("Home") ?>" >Go to Home Page</a>
    <p> <?=$exception?></p>


<?php
}