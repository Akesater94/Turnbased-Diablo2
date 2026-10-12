<?php
require_once basePath('Core/gamedata.php');

header('Content-Type: application/json');
if (!isset($_SESSION['player']) || !($_SESSION['current-monster'])) {
    echo json_encode(['success' => false]);
    exit;
}

$Player = $_SESSION['player'];
$monster = $_SESSION['current-monster'];
$monsterJustDied = false;

$monster->recieveDamage($Player->damage);

$leveledUp = false;
if($monster->isDead()){
    $leveledUp = $Player->gainExp($monster->expReward);
    $monsterJustDied = true;
}

$Player->updateStats();
$_SESSION['current-monster'] = $monster; 
$_SESSION['player'] = $Player;

echo json_encode(array_merge(
    [
        'success' => true, 
        'monsterDead' => $monsterJustDied
    ],
    $Player->getPublicState($leveledUp),
    $monster->getPublicState()
));