<?php
if (!file_exists("../Core/db.php"))
{
  copy("../Core/db.php.example", "../Core/db.php");
}


const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'utils.php';
require_once basePath('Core/gamedata.php');
require basePath('router.php');
?>