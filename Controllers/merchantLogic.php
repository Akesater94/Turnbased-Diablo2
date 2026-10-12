<?php

$_SESSION['is-at-merchant'] = true;

if (!isset($_SESSION['merchant'])) {
    $_SESSION['merchant'] = $Merchants["Charsi"];
}

$startDisplay = 'display: flex';

$merchant = $_SESSION['merchant'];
$merchantInventory = $merchant->inventory;

$nullItems = 0;

foreach($merchantInventory as $Index => $slot){
    if($slot === null){
        // dd($merchantInventory[$Index]);
        $nullItems += 1;
    }

}
// dd($merchantInventory);
// dd($nullItems);
if($nullItems >= 10){
    $_SESSION['merchant']->generateInventory($Items);
    $nullItems = 0;
    $_SESSION['merchant'] = $merchant;
}

require __DIR__. "/../Views/merchant.php"
?>