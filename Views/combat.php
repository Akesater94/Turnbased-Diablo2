<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="favicon.ico" rel="icon">
    <script src="Js/combat.js" defer></script>
    <script src="Js/inventory.js" defer></script>
    <script src="Js/charmenu.js" defer></script>
    <link rel="stylesheet" href="Css/styles.css">
</head>

<body id="combatZone">
    <div id="player-damage"> <?php echo $_SESSION['player']->damage ?></div>

    <div id="monster-container">
        <div id="hp-bar-outer">
            <div id="hp-bar-inner"></div>
            <span id="monster-name">
                <?php echo $_SESSION['current-monster']->name ?>
            </span>
        </div>
        <img id="monster-image" src=<?php echo $_SESSION['current-monster']->imageSource ?>>
    </div>

    <div class="player-exp">
        <div class="exp-bar-container">
            <div id="exp-bar-text"><?= (int)$expPercent."%" ?></div>
            <div id="exp-bar" class="exp-bar-filler"
                style="width: <?php echo $expPercent ?>%;">
            </div>
        </div>
    </div>
    <div id="potion">
        <img class="potion-image" onclick="usePotion()" src="Assets/images/healingPotion.jpg">
    </div>

    <div id="outer-health-orb">
        <div id="inner-health-orb" style="height: <?php echo ($_SESSION['player']->health / $_SESSION['player']->maxHealth) * 100; ?>%;"></div>
    </div>

    <a id="home-button" href="hub">
        <img src="Assets/images/Portal.webp">
    </a>

    <div id="inventory-and-equipment">
        <?php drawInventory(); ?>
        <?php drawEquipmentWindow(); ?>
    </div>
            <?php drawCharacterWindow(); ?>
</body>

</html>