<?php
class User {
    private $id;
    private $userName;
    private $email;
    private $password;

    function __construct($userName, $email, $password) {
        $this->userName = $userName;
        $this->email = $email;
        $this->password = $password;
    }

    function getId() {
        return $this->id;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function getUserName() {
        return $this->userName;
    }

    function setUserName($userName): void {
        $this->userName = $userName;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function getPassword() {
        return $this->password;
    }

    function setPassword($password): void {
        $this->password = $password;
    }
}
?>
