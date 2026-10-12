<?php require_once 'Core/gamedata.php' ?>
    <table class="areas-table">
        <?php foreach ($Areas as $areaKey => $area): ?>
            <tr>
                <td>
                    <a href="game.php?Id=combatArea&area=<?php echo urlencode($areaKey); ?>">
                        <?php echo $area->name; ?>
                    </a>
                </td>
                <td class="monster-lv"><?php echo "Monster level: " . $area->level; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>