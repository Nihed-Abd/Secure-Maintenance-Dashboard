<?PHP
	include "../../Controller/voyageC.php";

	$voyageC=new voyageC();
	
	if (isset($_POST["id"])){
		$voyageC->supprimerVoyage($_POST["id"]);
		header ('Location:listVoyage.php');
	}
?>