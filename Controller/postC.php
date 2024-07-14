<?php
include_once("../config.php");
include("../Model/post.php");

class postC {

	function ajouterPost($post){
		$sql = "INSERT INTO technicien (nom, codeBarre, image, picReal, codeQrBarre, dateFabrication, typePreventif) 
				VALUES (:nom, :codeBarre, :image, :picReal, :codeQrBarre, :dateFabrication, :typePreventif)";
		$db = new config();
		$conn = $db->getConnexion();
		try {
			$query = $conn->prepare($sql);
			$query->execute([
				'nom' => $post->getNom(),
				'codeBarre' => $post->getCodeBarre(),
				'image' => $post->getImage(),
				'picReal' => $post->getPicReal(),
				'codeQrBarre' => $post->getCodeQrBarre(),
				'dateFabrication' => $post->getDateFabrication(),
				'typePreventif' => $post->getTypePreventif()
			]);
			return true; // Return true if the query executed successfully
		} catch (Exception $e) {
			echo 'Erreur: ' . $e->getMessage();
			return false; // Return false if there was an error
		}
	}
	
    function afficherPosts(){
        $sql = "SELECT * FROM technicien";
        $conn = new config();
        $db = $conn->getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function chercherPostParCodeBarre($codeBarre){
        $sql = "SELECT * FROM technicien WHERE codeBarre LIKE :codeBarre";
        $conn = new config();
        $db = $conn->getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['codeBarre' => "%$codeBarre%"]); // Using wildcard % to match partial codeBarre
            $liste = $query->fetchAll();
            return $liste;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function countPostsByType() {
        $sql = "SELECT typePreventif, COUNT(*) as count FROM technicien GROUP BY typePreventif";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
    
    public function countAllPosts() {
        $sql = "SELECT COUNT(*) as count FROM technicien";
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

    public function getPostsForNotification() {
        $sql = "SELECT * FROM technicien WHERE 
                (typePreventif = 'daily' AND DATEDIFF(NOW(), dateFabrication) % 1 = 0) OR
                (typePreventif = 'weekly' AND DATEDIFF(NOW(), dateFabrication) % 7 = 0) OR
                (typePreventif = 'monthly' AND DATEDIFF(NOW(), dateFabrication) % 30 = 0) OR
                (typePreventif = 'yearly' AND DATEDIFF(NOW(), dateFabrication) % 365 = 0)";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
    
}
?>
