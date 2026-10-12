<?php
require_once basePath('Views/login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user = $_POST['username'];
    $pw = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $dbUser = $stmt->fetch();

    if($dbUser && password_verify($pw, $dbUser['password'])){
        $_SESSION['user-id']=$dbUser['id'];
        $_SESSION['username'] = $dbUser['username'];

        header("Location: selectChar");
        exit;
    } else {
        echo "Invalid username or password. <a href='../index.php'>Try again</a>";
    }
}

?>