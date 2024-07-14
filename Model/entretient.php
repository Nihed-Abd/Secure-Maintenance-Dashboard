<?php
class entretient {
    private $message;
    private $date;
    private $post_id;

    public function __construct($message, $date, $post_id) {
        $this->message = $message;
        $this->date = $date;
        $this->post_id = $post_id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getDate() {
        return $this->date;
    }

    public function getPostId() {
        return $this->post_id;
    }
}
?>
