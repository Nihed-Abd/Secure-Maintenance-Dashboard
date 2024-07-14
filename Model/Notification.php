<?php
class Notification {
    private $id;
    private $time;
    private $notification;
    private $userName;

    function __construct($time, $notification, $userName) {
        $this->time = $time;
        $this->notification = $notification;
        $this->userName = $userName;
    }

    // Getters
    function getId() {
        return $this->id;
    }

    function getTime() {
        return $this->time;
    }

    function getNotification() {
        return $this->notification;
    }

    function getUserName() {
        return $this->userName;
    }

    // Setters
    function setId($id) {
        $this->id = $id;
    }

    function setTime($time) {
        $this->time = $time;
    }

    function setNotification($notification) {
        $this->notification = $notification;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }
}
?>
