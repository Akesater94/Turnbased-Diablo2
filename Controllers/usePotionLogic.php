<?php
header('Content-Type: application/json');

$Player = $_SESSION['player'];

$Player->usePotion(50);

$_SESSION['player'] = $Player;

echo json_encode(
    $Player->getPublicState()
);