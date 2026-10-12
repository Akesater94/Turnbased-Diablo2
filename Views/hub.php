<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/styles.css">
    <script src="Js/hub.js" defer></script>
    <script src="Js/inventory.js" defer></script>
    <script src="Js/charmenu.js" defer></script>
</head>

<body class="hub">
    <ul class="hub-nav">
        <li class="inventory-button-container">
            <a class="inventory-button button">
                <image id="inventory-image" src="Assets/images/inventory.webp">
            </a>
        </li>
        <li class="buttons-container">
            <a class="waypoint-button button">
                <image id="waypoint" src="Assets/images/waypoint.webp">
            </a>
        </li>
        <li class="buttons-container">
            <a  href="merchant" class="merchant-button button">
                <image id="charsi" src="Assets/images/Charsi.webp">
            </a>
        </li>
    </ul>
    <div id="inventory-and-equipment">
        <?php drawInventory(); ?>
        <?php drawEquipmentWindow(); ?>
    </div>
    <?php drawWaypointWindow($Areas) ?>
    <?php drawCharacterWindow() ?>
</body>

</html>