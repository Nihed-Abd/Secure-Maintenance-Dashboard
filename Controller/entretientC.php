<?php
include_once("../config.php");
include_once("../Model/entretient.php");

class entretientC {
    public function ajouterEntretient($entretient) {
        $sql = "INSERT INTO entretient (message, date, post_id) VALUES (:message, :date, :post_id)";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                'message' => $entretient->getMessage(),
                'date' => $entretient->getDate(),
                'post_id' => $entretient->getPostId()
            ]);
            return true; // Return true if the query executed successfully
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false; // Return false if there was an error
        }
    }

    public function afficherEntretients() {
        $sql = "SELECT * FROM entretient";
        $conn = new config();
        $db = $conn->getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
?>
