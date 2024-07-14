<?php
include_once("../config.php");
include("../Model/Notification.php");

class NotificationController {

    // Function to add a new notification
    function addNotification($notification) {
        $sql = "INSERT INTO notification (time, notification, userName) VALUES (:time, :notification, :userName)";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                'time' => $notification->getTime(),
                'notification' => $notification->getNotification(),
                'userName' => $notification->getUserName()
            ]);
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Function to get all notifications
    function getAllNotifications() {
        $sql = "SELECT * FROM notification";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Function to get a notification by ID
    function getNotificationById($id) {
        $sql = "SELECT * FROM notification WHERE id = :id";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Function to update a notification
    function updateNotification($notification) {
        $sql = "UPDATE notification SET time = :time, notification = :notification, userName = :userName WHERE id = :id";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                'time' => $notification->getTime(),
                'notification' => $notification->getNotification(),
                'userName' => $notification->getUserName(),
                'id' => $notification->getId()
            ]);
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Function to delete a notification
    function deleteNotification($id) {
        $sql = "DELETE FROM notification WHERE id = :id";
        $db = new config();
        $conn = $db->getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->execute(['id' => $id]);
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
?>
