<?php

namespace systeme\Model;

use Ifsnop\Mysqldump as Imdump;
use Ifsnop\Mysqldump\Mysqldump;

#[\AllowDynamicProperties]
class Backup
{
    private $host;
    private $name;
    private $pass;
    private $user;
    private $storage;
    private $filename;
    private $dumpSettings;

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

    /**
     * @return mixed
     */
    public function getDumpSettings()
    {
        return $this->dumpSettings;
    }

    /**
     * @param mixed $dumpSettings
     */
    public function setDumpSettings($dumpSettings): void
    {
        $this->dumpSettings = $dumpSettings;
    }

    public function __construct()
    {
        $infos = $_SESSION['database'];
        $this->host = $infos['serveur'];
        $this->name = $infos['nom_base'];
        $this->user = $infos['utilisateur'];
        $this->pass = $infos['motdepasse'];
        $this->storage = $_SERVER['DOCUMENT_ROOT'] . "/backup/";
        $this->filename = "Backup_" . $infos['nom_base'] . "_" . date("Y-m-d_H-i-s") . ".sql";
        $this->dumpSettings = self::getDefaultDumpSettings();
    }

    private function getDefaultDumpSettings(): array
    {
        return array(
            'include-tables' => array(),
            'exclude-tables' => array(),
            'compress' => Mysqldump::NONE,
            'no-data' => array(),
            'if-not-exists' => false,
            'reset-auto-increment' => false,
            'add-drop-database' => false,
            'add-drop-table' => true,
            'add-drop-trigger' => true,
            'add-locks' => true,
            'complete-insert' => false,
            'databases' => false,
            'disable-keys' => true,
            'extended-insert' => true,
            'events' => false,
            'hex-blob' => true,
            'insert-ignore' => false,
            'net_buffer_length' => Mysqldump::MAXLINESIZE,
            'no-autocommit' => true,
            'no-create-db' => false,
            'no-create-info' => false,
            'lock-tables' => true,
            'routines' => false,
            'single-transaction' => true,
            'skip-triggers' => false,
            'skip-tz-utc' => false,
            'skip-comments' => true,
            'skip-dump-date' => true,
            'skip-definer' => true,
            'where' => '',
            'disable-foreign-keys-check' => true,
            'default-character-set' => Mysqldump::UTF8,
            'init_commands' => array(
                'SET NAMES utf8 COLLATE utf8_general_ci'
            ),
        );
    }

    public function make()
    {

        try {
            $dump = new Imdump\Mysqldump("mysql:host={$this->getHost()};dbname={$this->getName()}", "{$this->getUser()}", "{$this->getPass()}", self::getDefaultDumpSettings());
            if (self::IsDirOrCCreateIt($this->storage)) {
                $dump->start("{$this->storage}{$this->filename}");
                return "ok";
            } else {
                return "no";
            }

        } catch (\Exception $e) {
            return "Erreur backup" . $e->getMessage();
        }
    }
    public function makeCron($localhost,$db_name,$db_user,$db_pass,)
    {
        date_default_timezone_set('America/Port-au-Prince');
        $storage="../../../backup/";
        $filename="Backup_" . $db_name . "_" . date("Y-m-d_H-i-s") . ".sql";
        try {
            $dump = new Imdump\Mysqldump("mysql:host={$localhost};dbname={$db_name}", "{$db_user}", "{$db_pass}", $this->getDumpSettings());
            if (self::IsDirOrCCreateIt($storage)) {
                $dump->start("{$storage}{$filename}");
                return "ok";
            } else {
                return "no";
            }

        } catch (\Exception $e) {
            return "Erreur backup" . $e->getMessage();
        }
    }


    public function IsDirOrCCreateIt($path)
    {
        if (is_dir($path)) {
            return true;
        } else {
            if (mkdir($path, 0777, true)) {
                return true;
            } else {
                return false;
            }
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

    public function ListeFiles()
    {
        if (self::IsDirOrCCreateIt($this->storage)) {
            $fileArray = [];
            $files = scandir($this->storage);
            foreach ($files as $file) {
                if (is_file($this->storage . $file)) {
                    $fileArray[] = [
                        'name' => $file,
                        'modified' => date("Y-m-d H:i:s", filemtime($this->storage . $file)),
                        'size' => round(filesize($this->storage . $file) / (1024 * 1024), 2) . ' MB'  // Convert bytes to MB

                    ];
                }
            }

            return $fileArray;
        }
    }
}
