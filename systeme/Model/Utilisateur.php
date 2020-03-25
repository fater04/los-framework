<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 12/03/2018
 * Time: 21:34
 */

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
        try {
            if (self::SiPseudoExiste($this->getPseudo())) {
                return "pseudo existe";
            } else {
                $req = "insert into utilisateur (pseudo, email, role, nom, prenom, motdepasse, active,photo,telephone) VALUES 
        ('" . $this->pseudo . "','" . $this->email . "','" . $this->role . "','" . $this->nom . "','" . $this->prenom . "','" . $this->motdepasse . "','" . $this->active . "','" . $this->photo . "','" . $this->telephone . "')";
                if (self::connection()->query($req)) {
                    $con = null;
                    return "ok";
                } else {
                    $con = null;
                    return "no";
                }
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }


    }
    public function Enregistrer_online()
    {
        try {
            if (self::SiPseudoExiste($this->getPseudo())) {
                return "pseudo";
            } else if (self::SiEmailExiste($this->getEmail())) {
                return "email";
            } else {
                $req = "insert into utilisateur (pseudo, email, motdepasse,role) VALUES 
        ('" . $this->pseudo . "','" . $this->email . "','" . $this->motdepasse . "','" . $this->role . "')";
                if (self::connection()->query($req)) {
                    $con = null;
                    return "ok";
                } else {
                    $con = null;
                    return "no";
                }
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }


    }


    /**
     * rechercher utilisateur
     * @param $critere
     * @return Utilisateur|null
     */
    public static function Rechercher($critere)
    {
        $req = "select *from utilisateur where id='" . $critere . "' or pseudo='" . $critere . "' or email='" . $critere . "' or telephone='" . $critere . "'";
        $rs = self::connection()->query($req);
        if ($data = $rs->fetch()) {
            $con = null;
            $u = new Utilisateur();
            $u->setId($data['id']);
            $u->setNom($data['nom']);
            $u->setPrenom($data['prenom']);
            $u->setEmail($data['email']);
            $u->setRole($data['role']);
            $u->setActive($data['active']);
            $u->setMotdepasse($data['motdepasse']);
            $u->setPseudo($data['pseudo']);
            $u->setStatut($data['statut']);
            $u->setPhoto($data['photo']);
            $u->setTelephone($data['telephone']);
            return $u;

        } else {
            $con = null;
            return null;
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
            $req = "select *from utilisateur where (pseudo='" . $critere . "' or email='" . $critere . "' or telephone='" . $critere . "') ";
            $rs = self::connection()->query($req);
            if ($data = $rs->fetch()) {
                if (password_verify($motdepasse, $data['motdepasse'])) {
                    if (isset($_SESSION['utilisateur'])) {
                        return "session";
                    } else {
                        if (!self::SiUtilisateurActive($data['id'])) {
                            return "inactif";
                        } else {
                            /* if (self::SiUtilisateurConnecter($data['id'])) {

                                 return "Imposible de se connecter, Vous etes deja connecter sur un autre ordinateur , <br />
                                 Deconnecter avant de recommencer
                                  ";
                             } else {*/
                            $re = "UPDATE utilisateur SET statut='1' WHERE id='" . $data['id'] . "'";
                            self::connection()->query($re);
                            $_SESSION['utilisateur'] = $data['id'];
                            $_SESSION['pseudo'] = $data['pseudo'];
                            $_SESSION['role'] = $data['role'];
                            return "ok";
                            //}
                        }
                    }
                }else {
                    return "incorrect";
                }
            } else {
                return "incorect";
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
            $re = "UPDATE utilisateur SET statut='0' WHERE id='" . $id . "'";
            self::connection()->query($re);
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


    /**
     * @return bool
     */
    public function modifier()
    {

        $req = "update utilisateur set nom='" . $this->nom . "',motdepasse='" . $this->motdepasse . "',email='" . $this->email . "',pseudo='" . $this->pseudo . "',role='" . $this->role . "' where id='" . $this->id . "'";
        if (self::connection()->query($req)) {
            $con = null;
            return "ok";
        } else {
            $con = null;
            return "non";
        }
    }

    public function modifierP()
    {

        $req = "update utilisateur set prenom='" . $this->prenom . "',nom='" . $this->nom . "',email='" . $this->email . "',telephone='" . $this->telephone . "',photo='" . $this->photo. "' where id='" . $this->id . "'";
        if (self::connection()->query($req)) {
            $con = null;
            return "ok";
        } else {
            $con = null;
            return "non";
        }
    }
    public function modifierS()
    {

        $req = "update utilisateur set prenom='" . $this->prenom . "',nom='" . $this->nom . "',email='" . $this->email . "',telephone='" . $this->telephone . "' where id='" . $this->id . "'";
        if (self::connection()->query($req)) {
            $con = null;
            return "ok";
        } else {
            $con = null;
            return "non";
        }
    }

    /**
     * Lister tout les utilisateur
     * @return array
     */
    public function Lister()
    {
        $resultat = array();
        $req = "select *from utilisateur";
        $rs = self::connection()->query($req);
        while ($data = $rs->fetch()) {
            $u = new Utilisateur();
            $u->setId($data['id']);
            $u->setNom($data['nom']);
            $u->setPseudo($data['pseudo']);
            $u->setPrenom($data['prenom']);
            $u->setEmail($data['email']);
            $u->setRole($data['role']);
            $u->setActive($data['active']);
            $u->setMotdepasse($data['motdepasse']);
            $u->setStatut($data['statut']);
            $u->setPhoto($data['photo']);
            $u->setTelephone($data['telephone']);
            $resultat[] = $u;
        }
        $con = null;
        return $resultat;
    }

    /**
     * @return array|string
     */
    public static function listeOnline()
    {
        try {
            $u = \app\SystemeEcole\Models\Utilisateur::session_valeur();
            $con = self::connection();
            $req = "select *from utilisateur where statut='1' and id <> '" . $u . "' ";
            $stmt = $con->prepare($req);
            $stmt->execute();
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
        $req = "delete from utilisateur where id='" . $id . "'";
        self::connection()->query($req);
        $con = null;
    }

    /**
     * @param $id
     */
    public static function blocker($id)
    {
        $req = "update utilisateur set active='non' WHERE id='" . $id . "'";
        self::connection()->query($req);
        $con = null;
    }

    /**
     * @param $id
     */
    public static function deblocker($id)
    {
        $req = "update utilisateur set active='oui' WHERE id='" . $id . "'";
        self::connection()->query($req);
        $con = null;
    }

    /**
     * @return mixed
     */
    public static function pseudo()
    {
        if (isset($_SESSION['pseudo'])) {
            return $_SESSION['pseudo'];
        }
    }

    /**
     * @return mixed
     */
    public static function role()
    {
        if (isset($_SESSION['role'])) {
            return $_SESSION['role'];
        }
    }

    /**
     * @return mixed
     */
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
            $password = password_hash($password, PASSWORD_BCRYPT);
            $req = "update utilisateur set motdepasse='" . $password . "' where id='" . $id . "'";
            $con = self::connection();
            if ($con->query($req)) {
                return "ok";
            } else {
                return "no";
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public static function dernierId()
    {
        //include("fonction.php");
        $con = self::connection();
        $req = "SELECT *FROM utilisateur ORDER BY id DESC LIMIT 1";
        $rps = $con->query($req);
        $data = $rps->fetch();
        $id = $data['id'];
        $con = null;
        return $id;
    }


}