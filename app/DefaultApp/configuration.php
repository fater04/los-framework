<?php
//configuration base de donnee
$database = array(
    "serveur" => "localhost",
    "nom_base" => "bd",
    "utilisateur" => "root",
    "motdepasse" => "root"
);

//configuration email
$from=array(
    "email"=>"",
    "nom"=>""
);

$configurationEmail = array(
    "host" =>"",
    "utilisateur" =>"",
    "motdepasse" =>"",
    "port"=>465,
    "from"=>$from
);
//fin configuration email

$configuration = array(
    "url" => $_GET['url'],
    "database" => $database,
    "configurationEmail"=>$configurationEmail,
    "dossierProjet" => "/natcash_api",
    "nomApp" => "DefaultApp"
);
define("AUTHORIZENET_LOG_FILE", "phplog");
\systeme\Application\Configuration::addConfiguration($configuration,"DefaultApp");
//appelation fonction backup
//\systeme\Application\Application::Backup() ;
//appelation fonction liste de backup
//\systeme\Application\Application::BackupList() ;

//call api with curl
//$curlService = new \Ixudra\Curl\CurlService();
//$url = "https://event.bioshaiti.com/v1/user";
//$reponse = $curlService->to($url)
//    ->withData(array('token' => 'a61499960f807e19728547d8f2bdb33e3f5cd9e984503245'))
//    ->asJson()
//    ->get();
//var_dump($reponse);



