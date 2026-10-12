<?php


$stmt = $pdo->prepare("SELECT char_data, name, Id FROM characters WHERE user_id = :userId");
$stmt->execute(['userId' => $_SESSION['user-id']]);
$existingCharsJsonRows = $stmt->fetchAll();

$existingCharacters = [];

foreach($existingCharsJsonRows as $row){
    $existingCharacters[$row['Id']] = Player::playerFactory($row['char_data'], $HeroClasses);    
}

    $_SESSION['existingCharacters'] = $existingCharacters;
    
    require basePath('Views/charSelect.php');