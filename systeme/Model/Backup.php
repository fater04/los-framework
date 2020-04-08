<?php

namespace systeme\Model;

use Ifsnop\Mysqldump as Imdump;

class Backup
{
    private $host;
    private $name;
    private $pass;
    private $user;
    private $storage;
    private $filename;

    /**
     * Get the value of host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the value of host
     *
     * @return  self
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of pass
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set the value of pass
     *
     * @return  self
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of storage
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set the value of storage
     *
     * @return  self
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Get the value of filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @return  self
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function __construct($infos = array(), $root)
    {
        $this->host = $infos['serveur'];
        $this->name = $infos['nom_base'];
        $this->user = $infos['utilisateur'];
        $this->pass = $infos['motdepasse'];
        $this->storage = $root . "backup/";
        $this->filename = "Backup_" . date("Y_m_d_H_i_s") . ".sql";
    }

    public function make()
    {

        try {
            $dump = new Imdump\Mysqldump("mysql:host={$this->getHost()};dbname={$this->getName()}", "{$this->getUser()}", "{$this->getPass()}");
            if (self::IsDir_or_CreateIt($this->storage)) {
                $dump->start("{$this->storage}{$this->filename}");
                return "Une Sauvegarde  complète  de la base de donnée a été fait";
            } else {
                return "Une erreur est survenue lors de la création
                  du dossier " . $this->storage;
            }

        } catch (\Exception $e) {
            return "Erreur backup" . $e->getMessage();
        }
    }

    public function IsDir_or_CreateIt($path)
    {
        if (is_dir($path)) {
            return true;
        } else {
            if (mkdir($path)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function liste()
    {
        $message = "";
        if (isset($_GET['Delbackup'])) {
            $path = $this->storage . $_GET['Delbackup'];
            unlink($path);
            header("Refresh: 0; url=" . $_SERVER['HTTP_REFERER']);
            $message = "Supprimer !";
        }
        if (self::IsDir_or_CreateIt($this->storage)) {
            $folder = $this->storage;
            $dir = opendir($folder);
            $list = "";
            while ($file = readdir($dir)) {
                if ($file != '.' && $file != '..' && !is_dir($folder . $file)) {
                    $list .= "
               <tr>
               <td> " . $file . "</td>
               <td> <a href='" . $folder . "/" . $file . "' class='btn btn-info'><span class='fa fa-download'></span>telecharger</a></td>
               <td><a href='" . self::urlEncours() . "?Delbackup=" . $file . "' class='btn btn-danger'><span class='fa fa-trash'></span>supprimer</a></td>
               </tr>";
                }
            }
            closedir($dir);
            $table = "
        <div class='table-responsive'>
        " . $message . "
           <table class='table'>
           <table class='table table-hover table-bordered'>
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>DOWNLOAD</th>
                    <th>DELETE</th>
                </tr>
            </thead>
            <tbody>
                " . $list . "
            </tbody>
  </table>
          </table>
        </div>";
            return $table;
        } else {
            return "Une erreur est survenue lors de la création
              du dossier " . $this->storage;
        }
    }
    public function urlEncours()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https";
        } else {
            $url = "http";
        }

        // Ajoutez // à l'URL.
        $url .= "://";

        // Ajoutez l'hôte (nom de domaine, ip) à l'URL.
        $url .= $_SERVER['HTTP_HOST'];

        // Ajouter l'emplacement de la ressource demandée à l'URL
        $url .= $_SERVER['REQUEST_URI'];

        // Afficher l'URL
        return $url;
    }
}
