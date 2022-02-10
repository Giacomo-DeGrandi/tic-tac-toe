<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link rel="stylesheet" type="text/css" href="tris.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />

</head>

    <body>
        
        <header>
            <a href="index.php"><?= $title ?></a>
            <br>
            <h5>you're now on page <big>DEV</big></h5>
        </header>

        <aside>
            <?php
            if (isset($_SESSION["error"])) {
                echo $_SESSION["error"];
                unset($_SESSION["error"]);
            }

            if (isset($_SESSION["success"])) {
                echo $_SESSION["success"];
                unset($_SESSION["success"]);
            }
            ?>
        </aside>

        <?= $content ?>

    
        <footer>

        </footer>

    </body>

</html>