<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 20/03/2018
 * Time: 18:16
 */

namespace systeme\Routeur;
class Routeur
{

    private $url;
    private $routes=[];
    private $nomsRoute=[];

    public function __construct($url)
    {
        $this->url=$url;
    }


    public function get($chemin,$callable,$nom=null)
    {
      return $this->add($chemin,$callable,$nom,"GET");
    }


    public function post($chemin,$callable,$nom=null)
    {
      return $this->add($chemin,$callable,$nom,"POST");
    }

    private function add($chemin,$callable,$nom,$methode){
        $route=new Route($chemin,$callable);
        $this->routes[$methode][]=$route;
        if(is_string($callable) and $nom==null){
            $nom=$callable;
        }
        if($nom!=null){
            $this->nomsRoute[$nom]=$route;
        }
        return $route;
    }

    public function url($nom,$paramatres=[]){
        if(!isset($this->nomsRoute[$nom])){
            throw new \Exception("Aucun route trouver pour ce nom");
        }
        return  $this->nomsRoute[$nom]->getUrl($paramatres);
    }

    public function run()
    {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new \Exception("Methode non trouver");
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route){


            if($route->match($this->url)){

              return  $route->call();
            }
        }
        throw new \Exception("No route trouver pour ".$this->url);
    }

    public function redirection($nom_route,$parametres=[]){
        header("location: ".$this->url($nom_route,$parametres));
    }
}