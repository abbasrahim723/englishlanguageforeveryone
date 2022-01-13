<?php
session_start();
$user_email = $_POST['news_email'];
require_once 'emailController.php';
require_once "pdo.php";
if(isset($_POST['news_name']) && isset($_POST['news_email'])){
    $name = $_POST['news_name'];
    $email = $_POST['news_email'];
    $count = $pdo->query("SELECT * FROM news_letter where news_email='$email'")->fetchColumn();
   if(! $count == 0){
       $_SESSION['exist'] = "You have already Subscribed to our news letter";
       header('location:index.php#footer');
       return;
   }

    $sql = "INSERT INTO news_letter(news_name,news_email) values (:name,:email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['news_name'],
        ':email' => $_POST['news_email']
    ));
    sendSubscribtionEmail($user_email);

    header('location: welcome.php');
    return;
}
?>