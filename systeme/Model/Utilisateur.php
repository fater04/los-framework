<?php

namespace systeme\Model;

use Delight\Auth\Auth;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\Role;
use Delight\Auth\Status;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UnknownIdException;
use Delight\Auth\UserAlreadyExistsException;
use PDO;
use PHPMailer\PHPMailer\Exception;
use systeme\Application\Session;

#[\AllowDynamicProperties]
class Utilisateur extends Model
{

    private $id;
    private $pseudo;
    private $email;
    private $motdepasse;
    private $role;
    private $statut;
    private $nom;
    private $telephone;
    private $photo;
    private $verified;
    private $date_creation;
    private $derniere_connection;
    private $token;
    private $token_device;

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
    public function setId($id): void
    {
        $this->id = $id;
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
    public function getRole()
    {
        return $this->role;
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
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void
    {
        $this->photo = $photo;
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

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getMotdepasse()
    {
        return $this->motdepasse;
    }



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
    public function setMotdepasse($motdepasse)
    {
        $this->motdepasse = password_hash($motdepasse, PASSWORD_BCRYPT);
    }

    /**
     * @return mixed
     */
    public function getTokenDevice()
    {
        return $this->token_device;
    }

    /**
     * @param mixed $token_device
     */
    public function setTokenDevice($token_device): void
    {
        $this->token_device = $token_device;
    }

    public function Enregistrer()
    {
        try {

            if (self::SiTelephoneExiste($this->getTelephone())) {
                return "Phone exist";
            }
            if (self::SiEmailExiste($this->getEmail())) {
                return "Email exist";
            }
            $req = "INSERT INTO utilisateur (pseudo, email, role, nom,motdepasse, statut, photo, telephone) VALUES (:pseudo,:email, :role, :nom, :motdepasse, :statut, :photo, :telephone)";
            $pdo = self::connection();
            $stmt = $pdo->prepare($req);
            $stmt->bindParam(':pseudo', $this->pseudo, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
            $stmt->bindParam(':motdepasse', $this->motdepasse, PDO::PARAM_STR);
            $stmt->bindParam(':statut', $this->statut, PDO::PARAM_STR);
            $stmt->bindParam(':photo', $this->photo, PDO::PARAM_STR);
            $stmt->bindParam(':telephone', $this->telephone, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return "ok";
            } else {
                return "Ups, error!";
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function modifier($userId)
    {
        try {

            $req = "UPDATE utilisateur 
                SET pseudo = :pseudo, 
                    email = :email, 
                    role = :role, 
                    nom = :nom, 
                    statut = :statut, 
                    photo = :photo, 
                    telephone = :telephone";

            // Add password update only if it's provided
            if (!empty($this->motdepasse)) {
                $req .= ", motdepasse = :motdepasse";
            }

            $req .= " WHERE id = :userId";

            $pdo = self::connection();
            $stmt = $pdo->prepare($req);

            // Bind the parameters
            $stmt->bindParam(':pseudo', $this->pseudo, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
            $stmt->bindParam(':statut', $this->statut, PDO::PARAM_INT);
            $stmt->bindParam(':photo', $this->photo, PDO::PARAM_STR);
            $stmt->bindParam(':telephone', $this->telephone, PDO::PARAM_STR);

            // Bind the hashed password if it's being updated
            if (!empty($this->motdepasse)) {
                $hashedPassword = password_hash($this->motdepasse, PASSWORD_DEFAULT);
                $stmt->bindParam(':motdepasse', $hashedPassword, PDO::PARAM_STR);
            }

            // Bind the user ID
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            // Execute the update statement
            if ($stmt->execute()) {
                return "ok";
            } else {
                return "no";
            }
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage();
        }
    }


    private static function SiPseudoExiste($pseudo)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT * FROM utilisateur WHERE pseudo = :pseudo");
            $req->bindParam(':pseudo', $pseudo);
            $req->execute();
            $exists = $req->fetch() ? true : false;
            $con = null;
            return $exists;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    private static function SiEmailExiste($email)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT * FROM utilisateur WHERE email = :email");
            $req->bindParam(':email', $email);
            $req->execute();
            $exists = $req->fetch() ? true : false;
            $con = null;
            return $exists;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    private static function SiTelephoneExiste($telephone)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT * FROM utilisateur WHERE telephone = :telephone");
            $req->bindParam(':telephone', $telephone);
            $req->execute();
            $exists = $req->fetch() ? true : false;
            $con = null;
            return $exists;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    public static function updateMotDePasse($id, $motdepasse) {
        try {
            $motdepasse= password_hash($motdepasse, PASSWORD_BCRYPT);
            $con = self::connection();
            $req = $con->prepare("UPDATE utilisateur SET motdepasse = :motdepasse WHERE id = :id or email=:id");
            $req->bindParam(':motdepasse',  $motdepasse);
            $req->bindParam(':id', $id);
            if ($req->execute()) {
                $con = null;
                return "ok";
            } else {
                $con = null;
                return "non";
            }
        } catch (PDOException $e) {
            // Handle the exception (log it, rethrow it, or return an error message)
            return "Error: " . $e->getMessage();
        }
    }
    public function lister()
    {
        try {
            $con = self::connection();
            $req = "select *from utilisateur";
            $stmt = $con->prepare($req);
            $stmt->execute();
            $res = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\Model\Utilisateur");
            $con = null;
            return $res;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public static function updateEnLigne($id, $date = '')
    {
        try {
            if ($date == '') {
                $date = date('Y-m-d H:i:s');
            }
            $con = self::connection();
            $req = $con->prepare("UPDATE utilisateur SET derniere_connection = :date WHERE id = :id");
            $req->bindParam(':date', $date);
            $req->bindParam(':id', $id);

            if ($req->execute()) {
                $con = null;
                return "ok";
            } else {
                $con = null;
                return "non";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function retournerToken($id){
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT token FROM utilisateur WHERE id = :id");
            $req->bindParam(':id', $id);

            if ($req->execute()) {
                $data = $req->fetch(PDO::FETCH_ASSOC);
                $con = null;
                return $data ? $data['token'] : null;
            } else {
                $con = null;
                return null;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    public static function retournerTokenDevice($id){
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT token_device FROM utilisateur WHERE id = :id");
            $req->bindParam(':id', $id);

            if ($req->execute()) {
                $data = $req->fetch(PDO::FETCH_ASSOC);
                $con = null;
                return $data ? $data['token_device'] : null;
            } else {
                $con = null;
                return null;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function retournerOnline($id)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT derniere_connection FROM utilisateur WHERE colmado = :id");
            $req->bindParam(':id', $id);
            $req->execute();
            if ($data = $req->fetch(PDO::FETCH_ASSOC)) {
                $nom = $data['derniere_connection'];
            } else {
                $nom = '';
            }

            $con = null;
            return $nom;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function retournerEmail($id)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT email FROM utilisateur WHERE id = :id");
            $req->bindParam(':id', $id);
            $req->execute();
            $data = $req->fetch(PDO::FETCH_ASSOC);
            $con = null;
            return $data ? $data['email'] : null;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function retournerTelephone($id)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT telephone FROM utilisateur WHERE id = :id");
            $req->bindParam(':id', $id);
            $req->execute();

            $data = $req->fetch(PDO::FETCH_ASSOC);
            $con = null;
            return $data ? $data['telephone'] : null;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function retournerNomComplet($id)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT nom,prenom FROM utilisateur WHERE id = :id");
            $req->bindParam(':id', $id);
            $req->execute();

            $data = $req->fetch(PDO::FETCH_ASSOC);
            $con = null;
            return $data ? $data['nom']." ".$data['prenom'] : "";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function delete($id)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("DELETE FROM utilisateur WHERE id = :id");
            $req->bindParam(':id', $id);

            if ($req->execute()) {
                $con = null;
                return "ok";
            } else {
                $con = null;
                return "no";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function siBloquerDebloquer($id)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("SELECT statut FROM utilisateur WHERE id = :id");
            $req->bindParam(':id', $id);
            $req->execute();

            $data = $req->fetch(PDO::FETCH_ASSOC);
            $con = null;

            return $data ? $data['statut'] : null;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function retournerId($email)
    {
        try {
            $con = self::connection(); // Get the database connection
            $req = $con->prepare("SELECT id FROM utilisateur WHERE email = :email");
            $req->bindParam(':email', $email);
            $req->execute();

            $data = $req->fetch(PDO::FETCH_ASSOC);
            $con = null; // Close the connection

            return $data ? strval($data['id']) : "NON ATTRIBUER"; // Return ID or default message
        } catch (PDOException $e) {
            // Handle the exception (log it, rethrow it, or return an error message)
            return "Error: " . $e->getMessage();
        }
    }

    public static function updateToken($id)
    {
        try {
            $token=JwtToken::generateJWT($id);
            $con = self::connection();
            $req = $con->prepare("UPDATE utilisateur SET token = :token WHERE id = :id");
            $req->bindParam(':token', $token);
            $req->bindParam(':id', $id);
            if ($req->execute()) {
                $con = null;
                return "ok";
            } else {
                $con = null;
                return "no";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    public static function updateTokenDevice($id,$token)
    {
        try {
            $con = self::connection();
            $req = $con->prepare("UPDATE utilisateur SET token_device = :token WHERE id = :id");
            $req->bindParam(':token', $token);
            $req->bindParam(':id', $id);
            if ($req->execute()) {
                $con = null;
                return "ok";
            } else {
                $con = null;
                return "no";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    public static function deblocker($id)
    {
        try {
            $statut = 'oui';
            $con = self::connection();
            $req = "UPDATE utilisateur SET statut = :statut WHERE id = :id";
            $stmt = $con->prepare($req);

            $stmt->bindParam(':statut', $statut);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);



            if ($stmt->execute()) {
                return "ok";
            } else {
                return "Query execution failed: " . implode(", ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            return "Connection or query failed: " . $e->getMessage();
        }
    }

    public static function blocker($id)
    {
        try {
            $con = self::connection();
            $req = "UPDATE utilisateur SET statut = :statut WHERE id = :id";
            $stmt = $con->prepare($req);
            $statut = 'non';
            $stmt->bindParam(':statut', $statut);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);



            if ($stmt->execute()) {
                return "ok";
            } else {
                return "Query execution failed: " . implode(", ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            return "Connection or query failed: " . $e->getMessage();
        }
    }
    public static function pseudo()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['pseudo'])) {
            return $_SESSION['pseudo'];
        } else {
            return null; // or any other default value or behavior you prefer
        }
    }
    public static function role()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['role'])) {
            return $_SESSION['role'];
        } else {
            return null; // or any other default value or behavior you prefer
        }
    }
    public function ListerByRole($role)
    {
        $resultat = array();
        try {
            $con = self::connection();
            $req = "SELECT * FROM utilisateur WHERE role = :role";
            $stmt = $con->prepare($req);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
            $resultat = $stmt->fetchAll(PDO::FETCH_CLASS, "systeme\Model\Utilisateur");
        } catch (PDOException $e) {
            return "Connection or query failed: " . $e->getMessage();
        }
        return $resultat;
    }
    public static function retournerUser($id)
    {
        try {
            $con = self::connection();
            $req = "SELECT nom, prenom FROM utilisateur WHERE id = :id";
            $stmt = $con->prepare($req);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $nom = $data['nom'] . " " . $data['prenom'];
            } else {
                $nom = "NON ATTRIBUER";
            }

            return $nom;
        } catch (PDOException $e) {
            // Handle and return the error message
            return "Error: " . $e->getMessage();
        }
    }
    public static function session_valeur()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['utilisateur'])) {
            try {
               $decryptedData = Session::decryptSession($_SESSION['utilisateur']);
                return $decryptedData->utilisateur ?? null; // Use null coalescing to handle undefined properties
            } catch (Exception $e) {
                return "Error: " . $e->getMessage();
            }
        } else {
            return null;
        }
    }
    public static function session()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['utilisateur']);
    }
    public static function logout()
    {
        if (isset($_SESSION['utilisateur'])) {
            session_destroy();
            return true;
        } else {
            return false;
        }

    }
    public static function login($critere, $motdepasse)
    {
        try {
            $con = self::connection();

            $req = "SELECT * FROM utilisateur WHERE pseudo = :critere OR email = :critere OR telephone = :critere";
            $stmt = $con->prepare($req);
            $stmt->bindParam(':critere', $critere, PDO::PARAM_STR);
            $stmt->execute();
            if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($motdepasse, $data['motdepasse'])) {
                    if (isset($_SESSION['utilisateur'])) {
                        return "session";
                    } else {
                        if ($data['statut'] === "oui") {
                            $u1 = array();
                            $u1['utilisateur'] = strval($data['id']);
                            $u1['pseudo'] = $data['pseudo'];
                            $u1['role'] = $data['role'];
                            $_SESSION['utilisateur'] = Session::encryptSession($u1);
                            return "ok";
                        } else {
                            return "bloque";
                        }
                    }
                } else {
                    return "incorrect";
                }
            } else {
                return "incorrect";
            }
        } catch (PDOException $ex) {
            return "Error: " . $ex->getMessage();
        }
    }





























}