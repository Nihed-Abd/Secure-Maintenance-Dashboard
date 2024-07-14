<?php
include_once("../config.php");
include("../Model/user.php");

class userC {

    function signUp($user) {
        $sql = "INSERT INTO user (userName, email, password) VALUES (:userName, :email, :password)";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                'userName' => $user->getUserName(),
                'email' => $user->getEmail(),
                'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT) // Hashing the password for security
            ]);
            return true; // Return true if the query executed successfully
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false; // Return false if there was an error
        }
    }

    function login($email, $password) {
        $sql = "SELECT * FROM user WHERE email = :email";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute(['email' => $email]);
            $user = $query->fetch();
            if ($user && password_verify($password, $user['password'])) {
                return $user; // Return user data if authentication is successful
            } else {
                return false; // Return false if authentication fails
            }
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false; // Return false if there was an error
        }
    }
     // Check if email exists in the database
     public function getUserByEmail($email) {
        $sql = "SELECT * FROM user WHERE email = :email";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute(['email' => $email]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            return $user; // Return user data if found
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false; // Return false if there was an error
        }
    }

    // Update user password
    public function updatePassword($email, $newPassword) {
        $sql = "UPDATE user SET password = :password WHERE email = :email";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                'password' => password_hash($newPassword, PASSWORD_DEFAULT), // Hashing the new password
                'email' => $email
            ]);
            return true; // Return true if the password was updated successfully
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false; // Return false if there was an error
        }
    }
    public function countAllUsers() {
        $sql = "SELECT COUNT(*) as count FROM user";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC)['count'];
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
    
}
?>
