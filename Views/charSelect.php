<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="Css/styles.css">
</head>
<body>
    <ul class="list-of-characters">
        <?php foreach ($_SESSION['existingCharacters'] as $id => $character): ?>
            <li class='charcontainer'>
                <img src="<?php echo $character->Class->imgSourceSelect; ?>">
                <div class='text-box'>
                    <p><?php echo $character->name; ?></p>
                    <p>Level: <?php echo $character->level; ?></p>
                    <a id='play-button' href="handleChar?charIndex=<?php echo $id; ?>">Play</a>
                </div>
                <a class='delete-button' href='game.php?Id=charSelect&deleteIndex=<?php echo $id; ?>'>Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a id="create-character" href="createChar">Create new character</a>
</body>
</html>