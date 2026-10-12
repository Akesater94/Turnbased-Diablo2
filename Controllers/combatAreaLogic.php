<?php
require_once basePath('Core/gamedata.php');

if(isset($_GET['area']) && $_GET['area'] != null){
    $areaKey = $_GET['area'];
    $area = $Areas[$areaKey];
    $_SESSION['areaName'] = $area;
    $monsterTemplate = $area->monsters[array_rand($area->monsters)];

    $hpPercent = ($_SESSION['player']->health / $_SESSION['player']->maxHealth) * 100;
    $expPercent = ($_SESSION['player']->currentExp / $_SESSION['player']->maxExp) * 100;

    $monster = clone $monsterTemplate;
    $_SESSION['current-monster'] = $monster;
    $_SESSION['monster-max-health'] = $monster->health;

    require_once basePath('Views/combat.php');
}