<?php

class PasswordReset {
    private $id;
    private $email;
    private $token;
    private $expiryTimestamp;

    public function __construct($email, $token, $expiryTimestamp) {
        $this->email = $email;
        $this->token = $token;
        $this->expiryTimestamp = $expiryTimestamp;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function getExpiryTimestamp() {
        return $this->expiryTimestamp;
    }

    public function setExpiryTimestamp($expiryTimestamp) {
        $this->expiryTimestamp = $expiryTimestamp;
    }
}
?>
