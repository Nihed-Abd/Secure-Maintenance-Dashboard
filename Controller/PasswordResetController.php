<?php
include_once("../config.php");

class PasswordResetController {
    public function createResetToken($email, $token, $expiryTimestamp) {
        $sql = "INSERT INTO password_reset_tokens (email, token, expiry_timestamp) VALUES (:email, :token, :expiryTimestamp)";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                'email' => $email,
                'token' => $token,
                'expiryTimestamp' => $expiryTimestamp
            ]);
            return true;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }

    public function getCodeByEmail($email) {
        $sql = "SELECT token FROM password_reset_tokens WHERE email = :email AND expiry_timestamp > NOW()";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute(['email' => $email]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['token'] : false;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }

    public function getEmailByToken($token) {
        $sql = "SELECT email FROM password_reset_tokens WHERE token = :token AND expiry_timestamp > NOW()";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute(['token' => $token]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['email'] : false;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }

    public function deleteResetToken($token) {
        $sql = "DELETE FROM password_reset_tokens WHERE token = :token";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute(['token' => $token]);
            return true;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
}
?>
