<?php
require_once basePath('Core/gamedata.php');

header('Content-type: application/json');
if (!isset($_SESSION['player'])){
    echo json_encode(['success' => false]);
    exit;
}

$Player = $_SESSION['player'];
$statToUpgrade = $_POST['stat'];

if($Player->spendStatPoint($statToUpgrade)){
    $_SESSION['player'] = $Player;

    echo json_encode($Player->getPublicState());
    
} else {
    echo json_encode([
        'success' => false, 
    ]);
}