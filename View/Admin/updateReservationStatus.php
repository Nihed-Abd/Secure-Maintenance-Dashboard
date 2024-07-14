<?php
include("../../Controller/reservationC.php");

$reservationC = new reservationC();

if (isset($_POST['approve'])) {
    $idReservation = $_POST['id'];
    $reservationC->updateReservationStatus($idReservation, 'Approved');
} elseif (isset($_POST['decline'])) {
    $idReservation = $_POST['id'];
    $reservationC->updateReservationStatus($idReservation, 'Declined');
}
$idVoyage = $_POST['idVoy']; 

header("Location: listReservation.php?id=$idVoyage");
exit();
?>
