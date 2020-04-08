<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 30/03/2018
 * Time: 12:35
 */
/*NB: il est important de ne pas modifier cette classe 
,pour le bon fonctionnement du framework ,sauf si vous savez ce que vous faite.
Alcindor Losthelven Ing Informatique..
*/

namespace systeme\Application;
use systeme\Assette\Assette;
use systeme\Database\DbConnection;
use systeme\Model\Mail;
use systeme\Routeur\Routeur;
use systeme\Model\Backup;
class Application extends Session
{

    public static $config;

    public static $routeur;

    public static $connection=null;

    public static $dossierProjet;

    public static $assette;

    public static $nomApp;

    public static $configuration=array();

    public function __construct($configuration)
    {
        $_SESSION['database']=$configuration['database'];
        $_SESSION['configurationEmail']=$configuration['configurationEmail'];
        self::$configuration=$configuration;
        self::$routeur=new Routeur($configuration['url']);
        self::$dossierProjet=$configuration['dossierProjet'];
        self::$nomApp=$configuration['nomApp'];
        self::$assette=new Assette();
        self::$config=$configuration;
    }

    public static function get($chemin,$fonction,$nom=""){
        return self::$routeur->get($chemin,$fonction,$nom);
    }

    public static function post($chemin,$fonction,$nom=""){
           return self::$routeur->post($chemin,$fonction,$nom);
    }

    public static function genererUrl($nom_route,$parametres=[])
    {
        return self::$routeur->url($nom_route,$parametres);
    }

    public static function redirection($nom_route,$parametres=[]){

        self::$routeur->redirection($nom_route,$parametres);
    }


    public static function run(){
        return self::$routeur->run();
    }

    public static function connection(){
        $con=new DbConnection($_SESSION['database']);
        $con=$con->Connection();
        if(self::$connection==null){
            self::$connection=$con;
            return self::$connection;
        }else{
            return self::$connection;
        }
    }

    public static function envoyerEmail($a,$sujet,$contenue,$attachement="",$reply=""){
      $mail=new Mail($_SESSION['configurationEmail']);
      return $mail->envoyer($a,$sujet,$contenue,$attachement,$reply);
    }

    public static function ROOT(){
        return $_SERVER['DOCUMENT_ROOT']."/".self::$dossierProjet."/";
    }
    public static function Backup(){
        $bck=new Backup($_SESSION['database'],self::ROOT());
        return $bck->make();
    }
    public static function BackupList(){
        $bck=new Backup($_SESSION['database'],self::ROOT());
        return $bck->liste();
    }

    public static function css($css){
       return self::$assette->css($css);
    }

    public static function js($js){
        return self::$assette->js($js);
    }

    public static function image($image){
        return self::$assette->image($image);
    }

    public static function autre($autre){
        return self::$assette->autre($autre);
    }

    public static function configuration(){
        require self::ROOT()."app/configuration.php";
    }

    public static function nomApp(){
        return self::$nomApp;
    }

    public static function block($bloc){
        return self::$assette->bloc($bloc);
    }

    public static function routing(){
        require self::ROOT()."app/".self::nomApp()."/Routing.php";
    }

    public static function imageLocation(){
        return self::$assette->imageLocation();
    }

    public static function formatComptable($p){
        $p=str_replace(",","",$p);
        $r="#^[0-9]*.?[0-9]+$#";
        if(preg_match($r,$p))
        {
            $p=number_format($p, 2, '.', ',');
            return $p;
        }else{
            throw new \Exception("Format incorrect pour prix ou cout");
        }
    }




}