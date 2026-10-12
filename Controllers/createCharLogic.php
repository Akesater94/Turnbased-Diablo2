<?php

if(isset($_POST['hero-name'])) {
    $classKey = $_POST['selected-class'];
    $classObject = $HeroClasses[$classKey];
    
    $newChar = new Player($_POST['hero-name'], 10, 10, 1, 0 ,10, new PlayerItems(), $classObject);
    $newChar->className = $classKey;
    $jsonString = json_encode($newChar);
    
    $stmt = $pdo->prepare(
        "INSERT INTO characters (user_id, name, char_data)
        VALUES (:userId, :charName, :charJson)"
    );
    
    $stmt->execute([
        'userId' => $_SESSION['user-id'],
        'charName' => $_POST['hero-name'],
        'charJson' => $jsonString
        ]);
        
        header("Location: selectChar");
        exit;
}

require basePath('Views/createChar.php');
?>