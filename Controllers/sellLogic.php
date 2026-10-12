<?php
require_once __DIR__ . '/../Core/gamedata.php';
header('Content-type: application/json');

$playerInventoryIndex = isset($_GET['slot']) ? (int)$_GET['slot'] : null;
$merchant = $_SESSION['merchant'];
$player = $_SESSION['player'];

$merchant->buyItemFromPlayer($playerInventoryIndex);

$_SESSION['merchant'] = $merchant;
$_SESSION['player'] = $player;

    echo json_encode(array_merge(
        [
            'success' => true,
            'MerchantInventoryHtml' => captureMerchantInventoryHtml($merchant),
            'PlayerInventoryHtml' => captureInventoryHtml($player),
        ],

        $player->getPublicState()
        
    ));


