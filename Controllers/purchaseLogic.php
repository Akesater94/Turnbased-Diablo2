<?php
require_once __DIR__ . '/../Core/gamedata.php';
header('Content-type: application/json');

$merchantInventoryIndex = isset($_GET['slot']) ? (int)$_GET['slot'] : null;
$Player = $_SESSION['player'];
$Merchant = $_SESSION['merchant'];

if($merchantInventoryIndex !== null && $Merchant->sellItemToPlayer($merchantInventoryIndex)){
    $_SESSION['merchant'] = $Merchant;

    echo json_encode(array_merge(
        [
            'success' => true,
            'MerchantInventoryHtml' => captureMerchantInventoryHtml($Merchant),
            'PlayerInventoryHtml' => captureInventoryHtml($Player),
        ],

        $Player->getPublicState()
    ));
} else {
    echo json_encode(['success' => false]);
}

?>