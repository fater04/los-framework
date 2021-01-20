<?php

namespace systeme\Model;

use Delight\Auth\Auth;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\Role;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UnknownIdException;
use Delight\Auth\UserAlreadyExistsException;
use PHPMailer\PHPMailer\Exception;

class Utilisateur extends Model
{

    private $id;
    private $pseudo;
    private $email;
    private $motdepasse;
    private $role;
    private $statut;
    private $nom;
    private $prenom;
    private $sexe;
    private $telephone;
    private $image;
    private $verified;
    private $date_creation;
    private $derniere_connection;

    /**
     * @return mixed
     */
    public function getId()
    {
        return self::auth()->getUserId();
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getRole()
    {
        return self::auth()->getRoles();
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }


    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
    public function setMotdepasse($motdepasse): void
    {
        $this->motdepasse = $motdepasse;
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
    public function setNom($nom): void
    {
        $this->nom = $nom;
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
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param mixed $sexe
     */
    public function setSexe($sexe): void
    {
        $this->sexe = $sexe;
    }

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
    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
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
    public function setStatut($statut): void
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * @param mixed $verified
     */
    public function setVerified($verified): void
    {
        $this->verified = $verified;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param mixed $date_creation
     */
    public function setDateCreation($date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return mixed
     */
    public function getDerniereConnection()
    {
        return $this->derniere_connection;
    }

    /**
     * @param mixed $derniere_connection
     */
    public function setDerniereConnection($derniere_connection): void
    {
        $this->derniere_connection = $derniere_connection;
    }


    public static function auth()
    {
        return new Auth(self::connection());
    }

    public static function roles()
    {
        return Role::getNames();
    }

    public static function username()
    {
        return self::auth()->getUsername();
    }

    public static function email()
    {
        return self::auth()->getEmail();
    }

    public static function status()
    {
        return self::auth()->getStatus();
    }


    public static function userInfo($user_id, $nom, $prenom, $sexe, $telephone, $image)
    {
        $con = self::connection();
        try {
            $req = "insert into users_info (user_id,nom, prenom,sexe,telephone,image) VALUES (:user_id,:nom, :prenom,:sexe,:telephone,:image)";
            $stmt = $con->prepare($req);
            $param = array(
                ":user_id" => $user_id,
                ":nom" => $nom,
                ":prenom" => $prenom,
                ":sexe" => $sexe,
                ":telephone" => $telephone,
                ":image" => $image
            );
            if ($stmt->execute($param)) {
                return "ok";
            } else {
                return "Oups une erreur s'est produite. veuillez réessayer !";

            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }


    public function ajouter()
    {
        try {
            $userId = self::auth()->registerWithUniqueUsername($this->email, $this->motdepasse, $this->pseudo);
            $resultat = self::userInfo($userId, $this->nom, $this->prenom, $this->sexe, $this->telephone, $this->image);
        } catch (InvalidEmailException $e) {
            $resultat = 'Invalid email address';
        } catch (InvalidPasswordException $e) {
            $resultat = 'Invalid password';
        } catch (UserAlreadyExistsException $e) {
            $resultat = 'User already exists';
        } catch (TooManyRequestsException $e) {
            $resultat = 'Too many requests';
        }

        return $resultat;
    }

    public function ajouterOnline()
    {
        try {
            $resultat = array();
            $userId = self::auth()->register($this->email, $this->password, $this->pseudo, function ($selector, $token) {
                $resultat['selector'] = $selector;
                $resultat['token'] = $token;
//                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
            });

            $resultat ['reponse'] = self::userInfo($userId, $this->nom, $this->prenom, $this->sexe, $this->telephone, $this->image);
        } catch (InvalidEmailException $e) {
            $resultat = 'Invalid email address';
        } catch (InvalidPasswordException $e) {
            $resultat = 'Invalid password';
        } catch (UserAlreadyExistsException $e) {
            $resultat = 'User already exists';
        } catch (TooManyRequestsException $e) {
            $resultat = 'Too many requests';
        }
        return $resultat;
    }

    public static function supprimer($id)
    {
        try {
            self::auth()->admin()->deleteUserById($id);
            $req = "delete from users_info where  user_id=:id";
            $stmt = self::connection()->prepare($req);
            if ($stmt->execute(array(
                ":id" => $id
            ))) {
                return "ok";
            } else {
                return "no";
            }
        } catch (UnknownIdException $e) {
            return 'no';
        }
    }

    public function lister()
    {
        $resultat = array();
        $req = "select id, email, username, status, verified, roles_mask, registered, last_login from users";
        $rs = self::connection()->query($req);
        while ($data = $rs->fetch()) {
            $rs1 = self::connection()->query("select * from users_info where user_id='" . $data['id'] . "'");
            $data1 = $rs1->fetch();
            $u = new Utilisateur();
            $u->setId($data['id']);
            $u->setPseudo($data['username']);
            $u->setEmail($data['email']);
            $u->setStatut($data['status']);
            $u->setRole($data['roles_mask']);
            $u->setVerified($data['verified']);
            $u->setDateCreation($data['registered']);
            $u->setDerniereConnection($data['last_login']);
            $u->setImage($data1['image']);
            $u->setTelephone($data1['telephone']);
            $u->setNom($data1['nom']);
            $u->setPrenom($data1['prenom']);
            $u->setSexe($data1['sexe']);
            $resultat[] = $u;
        }
        $con = null;
        return $resultat;
    }

    public function rechercher($id)
    {
        try {
            $con = self::connection();
            $req = "select id, email, username, status, verified, roles_mask, registered, last_login from users WHERE id=:id ";
            $stmt = $con->prepare($req);
            $stmt->execute(array(":id" => $id));
            $res = $stmt->fetchAll();
            if (count($res) > 0) {
                $rs1 = self::connection()->query("select * from users_info where user_id='" . $res[0]['id'] . "'");
                $data1 = $rs1->fetch();
                $u = new Utilisateur();
                $u->setId($res[0]['id']);
                $u->setPseudo($res[0]['username']);
                $u->setEmail($res[0]['email']);
                $u->setStatut($res[0]['status']);
                $u->setRole($res[0]['roles_mask']);
                $u->setVerified($res[0]['verified']);
                $u->setDateCreation($res[0]['registered']);
                $u->setDerniereConnection($res[0]['last_login']);
                $u->setImage($data1['image']);
                $u->setTelephone($data1['telephone']);
                $u->setNom($data1['nom']);
                $u->setPrenom($data1['prenom']);
                $u->setSexe($data1['sexe']);
                return $u;
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public static function ajouterRole($userId, $role)
    {
        try {
            self::auth()->admin()->addRoleForUserById($userId, $role);
            return "ok";
        } catch (UnknownIdException $e) {
            return 'Id Introuvable';
        }
    }

    public static function retirerRole($userId, $role)
    {
        try {
            self::auth()->admin()->removeRoleForUserById($userId, $role);
            return "ok";
        } catch (UnknownIdException $e) {
            return ('Id Introuvable');
        }
    }

    public static function checkRole($userId, $role)
    {
        try {
            if (self::auth()->admin()->doesUserHaveRole($userId, $role)) {
                return "oui";
            } else {
                return "non";
            }
        } catch (UnknownIdException $e) {
            return ('Unknown user ID');
        }
    }

    public static function changerMotdepasse($userId, $password)
    {
        try {
            self::auth()->admin()->changePasswordForUserById($userId, $password);
            return "ok";
        } catch (UnknownIdException $e) {
            return ('Unknown ID');
        } catch (InvalidPasswordException $e) {
            return ('Mot de passe Invalid');
        }
    }

    public static function login($email, $password, $duree)
    {
        try {
            if ($duree != null) {
                Auth::createRememberCookieName();
            }
            self::auth()->login($email, $password, $duree);
            return 'ok';
        } catch (\Delight\Auth\InvalidEmailException $e) {
            return " email incorrect !";
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            return 'Mot de passe Incorrect !';
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            return 'Email non verifié ';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            return "Oups une erreur s'est produite. veuillez réessayer plus tard!";

        }
    }

    public static function logout()
    {
        try {
            self::auth()->logOutEverywhereElse();
            self::auth()->destroySession();
            return "ok";
        } catch (NotLoggedInException $e) {
            return 'Not logged in';
        }
    }

    public static function verifierEmail($selector, $token)
    {
        try {
            self::auth()->confirmEmail($selector, $token);

            return 'ok';
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            return 'Invalid token';
        } catch (\Delight\Auth\TokenExpiredException $e) {
            return 'Token expired';
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            return 'Email address already exists';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            return "Oups une erreur s'est produite. veuillez réessayer plus tard!";
        }
    }

    public static function changerPasswordCurrentUser($olPassword, $newPassword)
    {
        try {
            self::auth()->changePassword($olPassword, $newPassword);

            return 'ok';
        } catch (\Delight\Auth\NotLoggedInException $e) {
            return 'Not logged in';
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            return 'Invalid password(s)';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            return 'Too many requests';
        }
    }

//if ($_POST['remember'] == 1) {
//$rememberDuration = (int) (60 * 60 * 24 * 365.25);
//}
//else {
//    $rememberDuration = null;
//}


}