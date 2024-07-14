<?PHP
	include "../../Controller/reservationC.php";

	$reservationC=new reservationC();
	
	if (isset($_POST["id"])){
		$reservationC->supprimerReservation($_POST["id"]);
		header ('Location:listReservation.php');
	}
?>