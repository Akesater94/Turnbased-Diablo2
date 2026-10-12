<?php 
$_POST['hero-name'] = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/styles.css">
</head>

<body>
    <form action="createChar" method="POST">
        <ul class="classes">
            <?php foreach($HeroClasses as $key => $class) : ?>
                <li class='class-option'>
                    <label>
                        <input type="radio" name="selected-class" value="<?php echo $key; ?>" required>
                        <img src="<?php echo $class->imgSource; ?>" width="100">
                        <p><?php echo $class->name; ?></p>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="input-section-create-char">
            <input type="text" name="hero-name" placeholder="Enter name" required>
        <button type="submit">Create</button>
        </div>
    </form>
</body>

</html>