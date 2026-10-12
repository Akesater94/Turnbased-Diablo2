<?php
require_once basePath('Core/gamedata.php');
$_SESSION['is-at-merchant'] = false;

$startDisplay = 'display: none';
// dd($_SESSION['player']->Inventory);
$charDataJson = json_encode($_SESSION['player']);

// dd($charDataJson);
$stmt = $pdo->prepare("UPDATE characters SET char_data = :charData WHERE id = :charId");
$stmt->execute(['charId' => $_SESSION['current-player-id'], 'charData' => $charDataJson]);

require basePath('Views/hub.php');
?>