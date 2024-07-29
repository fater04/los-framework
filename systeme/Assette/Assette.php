<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 30/03/2018
 * Time: 14:05
 */

namespace systeme\Assette;
use systeme\Application\Application;

class Assette
{
    public function css($css){
        return "".Application::$dossierProjet."/public/css/".$css.".css";
    }

    public function js($js){
        return "".Application::$dossierProjet."/public/js/".$js.".js";
    }

    public function image($image){
        return "".Application::$dossierProjet."/public/img/".$image;
    }

    public function autre($autre){
        return "".Application::$dossierProjet."/public/".$autre;
    }

    public function bloc($bloc){
        require "../app/".Application::nomApp()."/Vues/block/".$bloc.".php";
    }

    public function imageLocation(){
        return "".Application::$dossierProjet."/public/img/";
    }

    public function langue($lang){
        require "../app/".Application::nomApp()."/Langues/lang.".$lang.".php";
    }
}