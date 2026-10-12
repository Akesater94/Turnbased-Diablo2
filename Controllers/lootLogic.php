<?php
header('Content-Type: application/json');
$Player = $_SESSION['player'];
$Monster = $_SESSION['current-monster'];

$itemDrop = $Monster->dropItem(80);
if($Player->hasInventorySpace()){
    $Player->addItemToInventory($itemDrop);
}

$_SESSION['player'] = $Player;

    echo json_encode(
        [
            'success' => true,
            'PlayerInventoryHtml' => captureInventoryHtml($Player),
        ]);
?>