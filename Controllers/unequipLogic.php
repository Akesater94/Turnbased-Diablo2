<?php
require_once __DIR__ . '/../Core/gamedata.php';
header('Content-type: application/json');

$slotName = $_GET['slot'] ?? null;
$Player = $_SESSION['player'];

if ($slotName && $Player->unequipItem($slotName)) {

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
    echo json_encode([
        'success' => false
    ]);
}