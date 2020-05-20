<?php

namespace systeme\Model;

use PHPMailer\PHPMailer\Exception;

class Utilisateur extends Model
{
    private $id;
    private $pseudo;
    private $email;
    private $nom;
    private $prenom;
    private $role;
    private $active;
    private $motdepasse;
    private $statut;
    private $telephone;
    private $photo;

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }


    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param mixed $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return strtolower($this->pseudo);
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = (trim(addslashes(strtolower($pseudo))));
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return strtolower($this->email);
    }

    /**
     * @param mixed $email
     * @throws \Exception
     */
    public function setEmail($email)
    {

        if (!$email == "") {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->email = trim(addslashes(strtolower($email)));
            } else {
                throw new \Exception("Email invalide");
            }
        } else {
            $this->email = "";
        }

    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = trim(addslashes(strtolower($nom)));
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = trim(addslashes(strtolower($prenom)));
    }

    /**
     * @return mixed
     */
    public function getMotdepasse()
    {
        return $this->motdepasse;
    }

    /**
     * @param mixed $motdepasse
     */
    public function setMotdepasse($motdepasse)
    {
        $this->motdepasse = password_hash($motdepasse, PASSWORD_BCRYPT);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = strtolower($role);
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return strtolower($this->active);
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = strtolower($active);
    }


    /**
     * verifier s'il existe deja un pseudo
     * @param $pseudo
     * @return bool
     */
    private static function SiPseudoExiste($pseudo)
    {
        $req = "select *from utilisateur where pseudo='" . $pseudo . "'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }
    }


    /**
     * verifier s'il existe deja un email
     * @param $email
     * @return bool
     */
    private static function SiEmailExiste($email)
    {
        $req = "select *from utilisateur where email='" . $email . "'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }
    }

    private static function SiTelephoneExiste($telephone)
    {
        $req = "select *from utilisateur where telephone='" . $telephone . "'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }
    }

    /**
     * verifier si l'utilisateur est deja connecter sur le systeme
     * prend en parametre l'id de l'utilisatur
     * @param $id
     * @return bool
     */
    public static function SiUtilisateurConnecter($id)
    {
        $req = "select *from utilisateur where id='" . $id . "' and statut='1'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }

    }


    /**
     * verifier si l'utilisateur a le droit de se connecter sur le systeme
     * @param $id
     * @return bool
     */
    private static function SiUtilisateurActive($id)
    {
        $req = "select *from utilisateur where id='" . $id . "' and active='oui'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }

    }


    /**
     * d'ajouter un nouvel utilisateur
     * @return bool|string
     */
    public function Enregistrer()
    {
        $con = self::connection();
        try {
            if (self::SiPseudoExiste($this->getPseudo())) {
                return "pseudo existe ";
            } else if (self::SiEmailExiste($this->getEmail())) {
                return "email existe";
            } else {
                $req = "insert into utilisateur (pseudo, email, role, nom, prenom, motdepasse, active,photo,telephone) VALUES (:pseudo, :email, :role, :nom, :prenom, :motdepasse, :active,:photo,:telephone)";
                $stmt = $con->prepare($req);
                $param = array(
                    ":pseudo" => $this->pseudo,
                    ":email" => $this->email,
                    ":role" => $this->role,
                    ":nom" => $this->nom,
                    ":prenom" => $this->prenom,
                    ":motdepasse" => $this->motdepasse,
                    ":active" => $this->active,
                    ":photo" => $this->photo,
                    ":telephone" => $this->telephone
                );
                if ($stmt->execute($param)) {
                    return "ok";
                } else {
                    return "no";
                }
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }


    public function EnregistrerOnline()
    {
        $con = self::connection();
        try {
            if (self::SiPseudoExiste($this->getPseudo())) {
                return "pseudo";
            } else if (self::SiEmailExiste($this->getEmail())) {
                return "email";
            } else {
                $req = "insert into utilisateur (pseudo, email, motdepasse,role) VALUES   (:pseudo, :email, :motdepasse,:role)";
                $stmt = $con->prepare($req);
                $param = array(
                    ":pseudo" => $this->pseudo,
                    ":email" => $this->email,
                    ":motdepasse" => $this->motdepasse,
                    ":role" => $this->role
                );
                if ($stmt->execute($param)) {
                    return "ok";
                } else {
                    return "no";
                }
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * rechercher utilisateur
     * @param $critere
     * @return Utilisateur|null
     */
    public static function Rechercher($critere)
    {
        try {
            $con = self::connection();
            $req = "select *from utilisateur WHERE id=:id or pseudo=:id or email=:id or telephone=:id";
            $stmt = $con->prepare($req);
            $stmt->execute(array(":id" => $critere));
            $res = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\\Model\\Utilisateur");
            if (count($res) > 0) {
                return $res[0];
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }


    /**
     * connection
     * @param $critere
     * @param $motdepasse
     * @return string
     */
    public static function Connecter($critere, $motdepasse)
    {
        try {
            $con = self::connection();
            $req = "select  id,motdepasse from utilisateur WHERE  pseudo=:id or email=:id or telephone=:id";
            $stmt = $con->prepare($req);
            $stmt->execute(array(":id" => $critere));
            if ($data = $stmt->fetch()) {
                if (password_verify($motdepasse, $data['motdepasse'])) {
                    if (isset($_SESSION['utilisateur'])) {
                        return "Utilisateur déjà connecté ,session ouverte ";
                    } else {
                        if (!self::SiUtilisateurActive($data['id'])) {
                            return "Votre compte est inactif";
                        } else {
                            $re = "UPDATE utilisateur SET statut='1' WHERE id='" . $data['id'] . "'";
                            self::connection()->query($re);
                            $_SESSION['utilisateur'] = self::Rechercher($data['id']);
                            return "ok";
                        }
                    }
                } else {
                    return "Mot de passe Incorrect !";
                }
            } else {
                return "Utilisateur introuvable !";
            }


        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }

    }


    /**
     * deconnection
     * @return bool
     */
    public static function Deconnecter()
    {
        if (isset($_SESSION['utilisateur'])) {

            $id = $_SESSION['utilisateur'];
            $req = "UPDATE utilisateur SET statut='0' WHERE id='" . $id . "'";
            self::connection()->query($req);
            session_destroy();
            return true;
        } else {
            return false;
        }
    }


    /**
     * verifier si la session utilisateur existe
     * @return bool
     */
    public static function session()
    {
        if (isset($_SESSION['utilisateur'])) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * retourner la valeur de la sessio en cour
     * @return null
     */
    public static function session_valeur()
    {
        if (isset($_SESSION['utilisateur'])) {

            return $_SESSION['utilisateur'];
        } else {
            return null;
        }

    }

    public static function createTableUtilisateur()
    {
        $con = self::connection();
        $req = "CREATE TABLE `utilisateur` (
  `id` int NOT NULL,
  `pseudo` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `active` enum('oui','non') DEFAULT 'non',
  `motdepasse` varchar(500) DEFAULT NULL,
  `statut` varchar(50) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `telephone` varchar(50) DEFAULT NULL,
  `photo` varchar(900) NOT NULL DEFAULT '''n/a'''
) ENGINE=InnoDB ";


        $stmt = $con->prepare($req);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "no";
        }
    }

    /**
     * @return bool
     */


    public function modifierFull()
    {
        $con = self::connection();
        try {
            $req = "update utilisateur set nom=:nom,prenom=:prenom,motdepasse=:motdepasse,email=:email,pseudo=:pseudo,role=:role ,photo=:photo where id=:id";
            $stmt = $con->prepare($req);
            $param = array(
                ":nom" => $this->nom,
                ":prenom" => $this->prenom,
                ":photo" => $this->photo,
                ":motdepasse" => $this->motdepasse,
                ":email" => $this->email,
                ":pseudo" => $this->pseudo,
                ":role" => $this->role,
                ":id" => $this->id
            );
            if ($stmt->execute($param)) {
                return "ok";
            } else {
                return "no";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }


    public function modifierWithPhoto()
    {
        $con = self::connection();
        try {
            $req = "update utilisateur set nom=:nom,prenom=:prenom,email=:email,pseudo=:pseudo,role=:role ,photo=:photo where id=:id";
            $stmt = $con->prepare($req);
            $param = array(
                ":nom" => $this->nom,
                ":prenom" => $this->prenom,
                ":photo" => $this->photo,
                ":email" => $this->email,
                ":pseudo" => $this->pseudo,
                ":role" => $this->role,
                ":id" => $this->id
            );
            if ($stmt->execute($param)) {
                return "ok";
            } else {
                return "no";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function modifierSimple()
    {

        $con = self::connection();
        try {
            $req = "update utilisateur set nom=:nom,prenom=:prenom,email=:email,pseudo=:pseudo where id=:id";
            $stmt = $con->prepare($req);
            $param = array(
                ":nom" => $this->nom,
                ":prenom" => $this->prenom,
                ":email" => $this->email,
                ":pseudo" => $this->pseudo,
                ":id" => $this->id
            );
            if ($stmt->execute($param)) {
                return "ok";
            } else {
                return "no";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Lister tout les utilisateur
     * @return array
     */
    public static function lister()
    {
        try {
            $con = self::connection();
            $req = 'select *from utilisateur';
            $stmt = $con->prepare($req);
            $stmt->execute();
            $res = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\\Model\\Utilisateur");
            return $res;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @return array|string
     */
    public static function listeOnline()
    {
        try {
            $con = self::connection();
            $req = "select *from utilisateur where statut='1' and id <> :id ";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":id" => \app\SystemeEcole\Models\Utilisateur::session_valeur()
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\Model\Utilisateur");
            return $data;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @return array|string
     */
    public static function listeOffline()
    {
        try {
            $con = self::connection();
            $req = "select *from utilisateur where statut='0'";
            $stmt = $con->prepare($req);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\Model\Utilisateur");
            return $data;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @param $id
     */
    public static function Supprimer($id)
    {
        $con = self::connection();

        $req = "delete from utilisateur where  id=:id";

        $stmt = $con->prepare($req);

        if ($stmt->execute(array(
            ":id" => $id
        ))) {
            return "ok";
        } else {
            return "no";
        }
    }

    /**
     * @param $id
     */
    public static function blocker($id)
    {
        $con = self::connection();

        $req = "update utilisateur set active=:active  where  id=:id";
        $stmt = $con->prepare($req);

        if ($stmt->execute(array(
            ":active" => 'non',
            ":id" => $id
        ))) {
            return "ok";
        } else {
            return "no";
        }
    }

    /**
     * @param $id
     */
    public static function deblocker($id)
    {
        $con = self::connection();

        $req = "update utilisateur set active=:active  where  id=:id";
        $stmt = $con->prepare($req);

        if ($stmt->execute(array(
            ":active" => 'oui',
            ":id" => $id
        ))) {
            return "ok";
        } else {
            return "no";
        }
    }

    /**
     * @return mixed
     */
    public static function utilisateur()
    {
        if (isset($_SESSION['utilisateur'])) {
            return $_SESSION['utilisateur'];
        }
    }


    public static function password()
    {
        $req = "select motdepasse from utilisateur where id='" . self::session_valeur() . "'";
        $con = self::connection();
        $res = $con->query($req);
        $data = $res->fetch();
        return $data['motdepasse'];
    }

    /**
     * @param $id
     * @param $password
     * @return string
     */
    public static function changePassword($id, $password)
    {
        try {

            $con = self::connection();
            $req = "update utilisateur set motdepasse=:password  where  id=:id";
            $stmt = $con->prepare($req);

            if ($stmt->execute(array(
                ":password" => password_hash($password, PASSWORD_BCRYPT),
                ":id" => $id
            ))) {
                return "ok";
            } else {
                return "no";
            }

        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function dernierId()
    {
        $con = self::connection();
        $req = "select * from utilisateur order by id desc limit 1";
        $rs = $con->query($req);
        $data = $rs->fetch();
        return $data['id'];
    }

    public static function count()
    {
        $con = self::connection();
        $req = "select COUNT(*) as 'nb' from client ";
        $rs = $con->query($req);
        $data = $rs->fetch();
        return $data['nb'];

    }

    public static function retournerPseudo($id)
    {
        $con = self::connection();
        $req = "select pseudo from utilisateur where id='" . $id . "'";
        $rs = $con->query($req);
        $data = $rs->fetch();
        return $data['pseudo'];

    }
}