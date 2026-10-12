<?php require_once __DIR__ . '/../Core/gamedata.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="Css/styles.css">
</head>
<body>
    <h1>Create Account</h1>
    <form action="addUser" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
