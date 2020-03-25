<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 26/03/2018
 * Time: 14:39
 */

namespace systeme\Controlleur;
use systeme\Application\Application;

class Controlleur
{
    private $cheminVues="Vues/";
    private $template="Vues/templates/";
    protected $nom_template="principale";

    protected function render($vue,$variables=array(),$resources=array())
    {
        $v=explode("/",$vue);
        $vue=$this->cheminVues.$vue;
        ob_start();
        extract($resources);
        extract($variables);
        require \systeme\Application\Application::ROOT()."app/".\systeme\Application\Application::nomApp()."/".$vue.".php";
        $contenue=ob_get_clean();
        if($v[1]=="login" || $v[1]=="lock"){
            require \systeme\Application\Application::ROOT()."app/".\systeme\Application\Application::nomApp()."/".$this->template."login".".php";
        }else{
            require \systeme\Application\Application::ROOT()."app/".\systeme\Application\Application::nomApp()."/".$this->template.$this->nom_template.".php";
        }

    }

    protected function getModel($model)
    {
        $model="app\\".Application::nomApp()."\\Models\\".ucfirst($model);
        $model=new $model();
        return $model;
    }

    protected function textControle($text)
    {
        return trim(addslashes(htmlentities($text,ENT_QUOTES)));
    }

}
