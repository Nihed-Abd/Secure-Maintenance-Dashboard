<?php
class post {
    private $id;
    private $nom;
    private $codeBarre;
    private $image;
    private $picReal;
    private $codeQrBarre;
    private $dateFabrication;
    private $typePreventif;


    function __construct($nom, $codeBarre, $image, $picReal, $codeQrBarre, $dateFabrication , $typePreventif) {
        $this->nom = $nom;
        $this->codeBarre = $codeBarre;
        $this->image = $image;
        $this->picReal = $picReal;
        $this->codeQrBarre = $codeQrBarre;
        $this->dateFabrication = $dateFabrication;
        $this->typePreventif = $typePreventif;

    }

    function getId() {
        return $this->id;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function getNom() {
        return $this->nom;
    }

    function setNom($nom): void {
        $this->nom = $nom;
    }

    function getCodeBarre() {
        return $this->codeBarre;
    }

    function setCodeBarre($codeBarre): void {
        $this->codeBarre = $codeBarre;
    }

    function getImage() {
        return $this->image;
    }

    function setImage($image): void {
        $this->image = $image;
    }

    function getPicReal() {
        return $this->picReal;
    }

    function setPicReal($picReal): void {
        $this->picReal = $picReal;
    }

    function getCodeQrBarre() {
        return $this->codeQrBarre;
    }

    function setCodeQrBarre($codeQrBarre): void {
        $this->codeQrBarre = $codeQrBarre;
    }

    function getDateFabrication() {
        return $this->dateFabrication;
    }

    function setDateFabrication($dateFabrication): void {
        $this->dateFabrication = $dateFabrication;
    }

    function getTypePreventif() {
        return $this->typePreventif;
    }

    function setTypePreventif($typePreventif): void {
        $this->typePreventif = $typePreventif;
    }
}
?>
