<?php
require_once __DIR__ . '/../Core/gamedata.php';
header('Content-type: application/json');

$inventoryIndex = isset($_GET['slot']) ? (int)$_GET['slot'] : null;
$Player = $_SESSION['player'];

if($inventoryIndex !== null && $Player->equipItem($inventoryIndex)){
    $_SESSION['player'] = $Player;

    echo json_encode(array_merge(
        [
            'success' => true,
            'inventoryHtml' => captureInventoryHtml($Player),
            'equipmentHtml' => captureEquipmentHtml($Player)
        ],
        $Player->getPublicState()
    ));
} else {
    echo json_encode (['success' => false]);
}
