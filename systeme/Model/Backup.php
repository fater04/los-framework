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
        $this->filename="Backup_".date("Y_m_d_H_i_s").".sql";
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

}
