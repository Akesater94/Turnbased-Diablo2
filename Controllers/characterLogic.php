<?php
// dd($_GET['charIndex']);
//hämtar karaktärens id från charSelect.php genom $_GET sparar id till $index.
//Skickar oss sedan till hub där karaktären uppdateras i databasen.

if (isset($_GET['charIndex']) && $_GET['charIndex'] != null) {

    $index = $_GET['charIndex'];
    $_SESSION['player'] = $_SESSION['existingCharacters'][$index];
    $_SESSION['current-player-id'] = $index;
    $_SESSION['player']->updateStats();
    header("Location: hub");
}

//DEN HÄR SKITEN FUNGERAR INTE (än)
if (isset($_GET['deleteIndex'])) {
    $deleteIndex = $_GET['deleteIndex'];
    array_splice($_SESSION['existingCharacters'], $deleteIndex, 1);
    unset($_SESSION['player']);
}

?>