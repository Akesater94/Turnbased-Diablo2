<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$uri = str_replace(['/tbd2/public', '/tbd2'], '', $uri);

if ($uri === '' || $uri === '/') {
    $uri = '/';
}

$routes = [
    '/' => 'Controllers/indexLogic.php',
    '/login' => 'Controllers/loginLogic.php',
    '/register' => 'Controllers/registerLogic.php',
    '/addUser' => 'Controllers/addUserLogic.php',
    '/selectChar' => 'Controllers/selectCharlogic.php',
    '/createChar' => 'Controllers/createCharLogic.php',
    '/handleChar' => 'Controllers/characterLogic.php',
    '/hub' => 'Controllers/hubLogic.php',
    '/merchant' => 'Controllers/merchantLogic.php',
    '/combatZone' => 'Controllers/combatAreaLogic.php',
    '/strike' => 'Controllers/attackLogic.php',
    '/spawnNewEnemy' => 'Controllers/spawnLogic.php',
    '/equip' => 'Controllers/equipLogic.php',
    '/unequip' => 'Controllers/unequipLogic.php',
    '/buyItem' => 'Controllers/purchaseLogic.php',
    '/sellItem' => 'Controllers/sellLogic.php',
    '/addPoints' => 'Controllers/addpointsLogic.php',
    '/loot' => 'Controllers/lootLogic.php',
    '/monsterStrike' => 'Controllers/monsterAttackLogic.php',
    '/heal' => 'Controllers/usePotionLogic.php'
];

if(array_key_exists($uri, $routes)){
    require $routes[$uri];
} else {
    echo 'Hoppsan!';
}