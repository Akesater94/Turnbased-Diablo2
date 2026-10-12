<?php
require_once basePath('Models/models.php');
require_once basePath('Core/db.php');
session_start();

$Items = [
    "ShortSword" => new Item(
        name: "Short sword",
        damage: 4,
        aSpeed: 1500,
        typeOfItem: ItemEnum::MainHand,
        imageSource: 'Assets\images\shortsword.webp',
    ),

    "Cap" => new Item(
        name: "Cap",
        typeOfItem: ItemEnum::Helm,
        bonusStrength: 4,
        imageSource: 'Assets/images/helm.webp',
    ),

    "LeatherJacket" => new Item(
        name: "Leather Jacket",
        bonusVitality: 2,
        typeOfItem: ItemEnum::Body,
        imageSource: 'Assets/images/armor.webp',

    ),

    "SkullCap" => new Item(
        name: "Skull Cap",
        typeOfItem: ItemEnum::Helm,
        bonusVitality: 1,
        bonusStrength: 2,
        imageSource: 'Assets/images/SkullCap.webp',

    ),
];

$Fallen = new Monster("Fallen", 30, 1, 3, "Assets/images/fallenAttack.webp");
$Zombie = new Monster("Zombie", 80, 5, 6, "Assets/images/zombie.webp");
$QuilRat = new Monster("Quilrat", 50, 2, 4, "Assets/images/quilrat.webp");
$BloodMoorMonsters = [$Fallen, $Zombie, $QuilRat];
$BloodMoorItems = [$Items['ShortSword'], $Items['Cap'], $Items['LeatherJacket']];

$DarkRogue = new Monster("Dark Rogue", 100, 7, 15, "Assets/images/darkRogue.webp");
$Yeti = new Monster("Gargantuan", 120, 8, 10, "Assets/images/gargantuan.webp");
$Carver = new Monster("Carver", 50, 2, 7, "Assets/images/carver.webp");

$ColdPlainsMonsters = [$DarkRogue, $Yeti, $Carver];
$ColdPlainsItems = [$Items['SkullCap']];

$TestZombie = new Monster('Diablo', 1, 1, 100, "Assets/images/zombie.webp");
$TestMonster = [$TestZombie];


$Areas = [
    "Bloodmoor" => new Area(
        "Blood moor",
        1,
        $BloodMoorMonsters,
        $BloodMoorItems
    ),

    "Coldplains" => new Area(
        "Cold plains",
        3,
        $ColdPlainsMonsters,
        $ColdPlainsItems,
    ),
    "Test" => new Area(
        "Testing grounds",
        100,
        $TestMonster,
        $Items
    ),
];



$HeroClasses = [
    "Barbarian" => new heroClass(
        "Barbarian",
        "Assets/images/startingBarb.webp",
        "Assets/images/barb.webp",
        20,
        25,
        10
    ),

    "Sorceress" => new heroClass(
        "Sorceress",
        "Assets/images/startingSorceress.webp",
        "Assets/images/Sorceress.webp",
        10,
        15,
        25

    )
];

$Merchants = [
    "Charsi" => new Merchant()
];

function drawMerchantInventory(SplFixedArray $items)
{

    $MaxSlots = 18;
    echo "<tr>";
    for ($i = 0; $i < $MaxSlots; $i++) {
        if ($i > 0 && $i % 3 === 0) echo "</tr><tr>";

        echo "<td class='inventory-item'>";

        if (!is_null($items[$i])) {
            $item = $items[$i];

            echo "<a href='javascript:void(0)' onclick='purchaseItem($i)'>";
            echo "<image src=" . $item->imageSource . " class='item-image'>";
            echo "</a>";

            echo "<div class='tooltip'>";
            echo "<div class='item-name'>" . $item->name . "</div>";
            echo "<div class='item-type'>" . $item->typeOfItem->value . "</div>";
            if ($item->damage > 0) echo "<div>Damage: " . $item->damage . "</div>";
            if ($item->aSpeed > 0) echo "<div>Attack Speed: " . ($item->aSpeed / 1000) . "</div>";
            if ($item->bonusHealth > 0) echo "<div class='magic-stat'>Health + " . $item->bonusHealth . "</div>";
            if ($item->bonusEnergy > 0) echo "<div class='magic-stat'>Energy + " . $item->bonusEnergy . "</div>";
            if ($item->bonusStrength > 0) echo "<div class='magic-stat'>Strength + " . $item->bonusStrength . "</div>";
            if ($item->bonusVitality > 0) echo "<div class='magic-stat'>Vitality + " . $item->bonusVitality . "</div>";

            echo "</div>";
        } else {
            echo "<div class='empty-slot'></div>";
        }
        echo "</td>";
    }
}

function drawWaypointWindow($areas){
        echo "<table class='areas-table'>";
        foreach ($areas as $areaKey => $area){
            echo "<tr>
                    <td>
                        <a href='combatZone?area=".$areaKey."'>".$area->name."</a>
                    </td>
                    <td class='monster-lv'> Monster level: ". $area->level."></td>
                    </tr>";
        }
        echo "</table>";

}

function drawInventory()
{
    $items = $_SESSION['player']->Inventory;

    $merchantCheck = (isset($_SESSION['is-at-merchant']) && $_SESSION['is-at-merchant']) ? "sellItem" : "equipItem";

    $MaxSlots = 12;
    

    echo "<div id='inventory-container'><table id='player-inventory'><tr>";
    for ($i = 0; $i < $MaxSlots; $i++) {
        if ($i > 0 && $i % 2 === 0)  echo "</tr><tr>";

        echo "<td class='inventory-item'>";

        if (!is_null($items[$i])) {
            $item = $items[$i];

            echo "<a href='javascript:void(0)' onclick='$merchantCheck($i)'>";
            echo "<image src=" . $item->imageSource . " class='item-image'>";
            echo "</a>";

            echo "<div class='tooltip'>";
            echo "<div class='item-name'>" . $item->name . "</div>";
            echo "<div class='item-type'>" . $item->typeOfItem->value . "</div>";
            if ($item->damage > 0) echo "<div>Damage: " . $item->damage . "</div>";
            if ($item->aSpeed > 0) echo "<div>Attack Speed: " . ($item->aSpeed / 1000) . "</div>";
            if ($item->bonusHealth > 0) echo "<div class='magic-stat'>Health + " . $item->bonusHealth . "</div>";
            if ($item->bonusEnergy > 0) echo "<div class='magic-stat'>Energy + " . $item->bonusEnergy . "</div>";
            if ($item->bonusStrength > 0) echo "<div class='magic-stat'>Strength + " . $item->bonusStrength . "</div>";
            if ($item->bonusVitality > 0) echo "<div class='magic-stat'>Vitality + " . $item->bonusVitality . "</div>";

            echo "</div>";
        } else {

            echo "<div class='empty-slot'></div>";
        }

        echo "</td>";
    }
    echo "</table></div>";
}

function drawEquipmentWindow()
{
    $equippedItems = $_SESSION['player']->EquippedItems;

    echo "<div id='equipment-container'>";
    echo "<table id='equipment'>";
    echo "<tr>";
    $slots = ['Helm', 'Body', 'MainHand'];

    foreach ($slots as $slot) {
        $Item = $equippedItems->$slot;
        echo "<td class='inventory-item'>";

        if (!is_null($Item) && !empty($Item->imageSource)) {
            echo "<a href='javascript:void(0)' onclick=\"unequipItem('$slot')\">";
            echo "<img src='" . $Item->imageSource . "' class='item-image' title='" . $Item->name . "'>";
            echo "</a>";

            echo "<div class='tooltip'>";
            echo "<div class='item-name'>" . $Item->name . "</div>";
            echo "<div class='item-type'>" . $Item->typeOfItem->value . "</div>";
            if ($Item->damage > 0) echo "<div style='color: white;'>Damage: " . $Item->damage . "</div>";
            if ($Item->aSpeed > 0) echo "<div style='color: white;'>Attack Speed: " . ($Item->aSpeed / 1000) . "</div>";
            if ($Item->bonusHealth > 0) echo "<div class='magic-stat'>Health + " . $Item->bonusHealth . "</div>";
            if ($Item->bonusEnergy > 0) echo "<div class='magic-stat'>Energy + " . $Item->bonusEnergy . "</div>";
            if ($Item->bonusStrength > 0) echo "<div class='magic-stat'>Strength + " . $Item->bonusStrength . "</div>";
            if ($Item->bonusVitality > 0) echo "<div class='magic-stat'>Vitality + " . $Item->bonusVitality . "</div>";
            echo "</div>";
        } else {
            echo "<div class='empty-slot' data-slot='" . $slot . "'></div>";
        }

        echo "</td>";
    }
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}

function drawCharacterWindow()
{
    $player = $_SESSION['player'];
    $Strcolor = ($player->totalStr > $player->charStats->Strength) ? "#4850b8" : "#999999";
    $Vitcolor = ($player->totalVit > $player->charStats->Vitality) ? "#4850b8" : "#999999";
    $Engcolor = ($player->totalEng > $player->charStats->Energy) ? "#4850b8" : "#999999";

    $display = ($player->charStats->UnspentPoints > 0) ? "table-cell" : "none";

    echo "<div id='character-window-container'>";
    echo "<table id='character-window'>";
    echo "<tr><td>" . "Name" . "</td><td>" . $player->name . "</td></tr>";
    echo "<tr><td >" . "Level: " . "</td><td id=player-level>" . $player->level . "</td></tr>";
    echo "<tr><td>" . "Life: " . "</td><td id=player-health>" . $player->health."/".$player->maxHealth."</td></tr>";
    echo "<tr><td>" . "Damage: " . "</td><td id=char-window-player-damage>" . $player->damage . "</td></tr>";
    echo "<tr>
            <td>Strength</td>
            <td id='stat-Strength' style='color: $Strcolor'>" . $player->totalStr . "</td>
            <td class='add-stats' style='display: $display'><button class='add-point-btn' data-stat='Strength'>+</button></td>
            </tr>";
    echo "<tr>
            <td>Vitality</td>
            <td id='stat-Vitality' style='color: $Vitcolor'>" . $player->totalVit . "</td>
            <td class='add-stats' style='display: $display'><button class='add-point-btn' data-stat='Vitality'>+</button></td>
        </tr>";
    echo "<tr>
            <td>Energy</td>
            <td id='stat-Energy' style='color: $Engcolor'>" . $player->totalEng . "</td>
            <td class='add-stats' style='display: $display'><button class='add-point-btn' data-stat='Energy'>+</button></td>
        </tr>";
    echo "<tr>
                <td>STAT POINTS</td>
                <td id='unspent-points'>" . $player->charStats->UnspentPoints . "</td>
        </tr>";
    echo "</table>";
    echo "</div>";
}

function captureInventoryHtml($Player)
{
    ob_start();
    drawInventory($Player->Inventory);
    return ob_get_clean();
}

function captureMerchantInventoryHtml($Merchant){
    ob_start();
    drawMerchantInventory($Merchant->inventory);
    return ob_get_clean();
}

function captureEquipmentHtml($Player)
{
    ob_start();
    drawEquipmentWindow($Player->EquippedItems);
    return ob_get_clean();
}
