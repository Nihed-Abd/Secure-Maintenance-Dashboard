<?php
include ("../../Controller/postC.php");

$postC = new postC();
$listePosts = $postC->afficherPosts();

if(isset($_POST['submit'])) {
    $listePosts = $postC->afficherPosts();
}

if(isset($_POST['ajout'])) {
    header('Location: ../addPost.php');
}
?>
