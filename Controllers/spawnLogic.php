<?php 
require_once __DIR__ .  '/../Core/gamedata.php';

// dd($_SESSION['areaName']);

$CurrentArea = $_SESSION['areaName'];

$monsterTemplate = $CurrentArea->monsters[array_rand($CurrentArea->monsters, 1)];

$monster = clone $monsterTemplate;
$_SESSION['current-monster'] = $monster;
header('Content-Type: application/json');
echo json_encode(
        $monster->getPublicState()
    );
