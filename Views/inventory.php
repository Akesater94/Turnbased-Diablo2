    <?php
    require_once 'Core/gamedata.php';
    echo "<div id='inventory-and-equipment' style='$startDisplay';>";
        echo "<table id=player-inventory>";
            $MaxSlots = 12;
            echo "<tr>";
            for ($i = 0; $i < $MaxSlots; $i++) {
                if ($i > 0 && $i % 6 === 0)  echo "</><tr>";

                echo "<td class='inventory-item'>";
                if (!is_null($_SESSION['player']->Inventory[$i])) {
                    $item = $_SESSION['player']->Inventory[$i];

                    echo "<a href='javascript:void(0)' onclick='equipItem($i)'>";
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
        echo "</table>";

        //draw equips
        echo "<table id=equipment><tr>";

            $slots = ['Helm', 'Body', 'MainHand'];

            foreach ($slots as $slot) {
                // $Item = $_SESSION['player']->EquippedItems->$slot;
                $Item = null;
                echo "<td class='inventory-item'>";

                if (!is_null($Item) && !empty($Item->imageSource)) {
                    echo "<a href='javascript:void(0)' onclick=\"unequipItem('$slot')\">";
                    echo "<img src='" . $Item->imageSource . "' class='item-image' title='" . $Item->name . "'>";
                    echo "</a>";

                    echo "<div class='tooltip'>";
                    echo "<div class='item-name'>" . $Item->name . "</div>";
                    echo "<div class='item-type'>" . $Item->typeOfItem->value . "</div>";
                    if ($Item->damage > 0) echo "<div>Damage: " . $Item->damage . "</div>";
                    if ($Item->aSpeed > 0) echo "<div>Attack Speed: " . ($Item->aSpeed / 1000) . "</div>";
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

        echo "</tr></table>";
    echo "</div>";                
?>  