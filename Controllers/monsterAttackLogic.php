<?php
header('Content-Type: application/json');

$Player = $_SESSION['player'];
$Monster = $_SESSION['current-monster'];

$Player->recieveDamage($Monster->damage);

$_SESSION['current-monster'] = $Monster; 
$_SESSION['player'] = $Player;

echo json_encode(array_merge(
    [
        'success' => true,
    ],
    $Player->getPublicState(),
));
