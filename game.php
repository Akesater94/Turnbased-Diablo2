<?php
require_once 'Core/gamedata.php';

$routes = [
    'login' => 'Views/login.php',
    'register' => 'Views/register.php',
    'charSelect' => 'Controllers/selectCharlogic.php',
    'createChar' => 'Views/createChar.php',
    'hub' => 'Controllers/hubcontroller.php',
    'combatArea' => 'Controllers/combatArea.php',
    'merchant' => 'Controllers/merchantcontroller.php',
];

$page = $_GET['Id'] ?? 'charSelect';

if(array_key_exists($page, $routes)){
    require $routes[$page];
} else {
    require 'Views/charSelect.php';
}
