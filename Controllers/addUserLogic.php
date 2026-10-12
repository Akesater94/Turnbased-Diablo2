<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pw = $_POST['password'];

    $hashedPw = password_hash($pw, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (username, password) VALUES (?,?)";
    $stmt = $pdo->prepare($sql);

    try{
        $stmt->execute([$user, $hashedPw]);
        Header('Location: login');
    } catch(PDOException $e) {
        echo "error".$e->getMessage();
    }
}
?>