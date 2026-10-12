<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/styles.css">
    <script src="Js/merchant.js" defer></script>
</head>

<body class="hub">
    <ul class="hub-nav">
        <li class="buttons-container">
            <a href="hub" class="cancel-merchant-button button">
                <img src="Assets\images\cancelMerchant.jpg">
            </a>
        </li>
    </ul>
    <div id="merchant-inventory-container">
        <table id="merchant-inventory">
            <?php drawMerchantInventory($_SESSION['merchant']->inventory); ?>
        </table>
    </div>
    <?php drawInventory(); ?>
</body>

</html>