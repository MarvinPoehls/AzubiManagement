<!DOCTYPE html>
<html>
    <head>
        <title>Fatchip <?php echo $controller->getTitle(); ?></title>
        <link rel="stylesheet" href=<?php echo $controller->getUrl("styles2.css") ?>>
    </head>
    <body>
        <div class="mainContent">
            <a class="logo" href="https://www.fatchip.de/" target="_blank">
                <img src="https://www.tradebyte.io/wp-content/uploads/2020/12/fatchip_logo.png" alt="Fatchip Logo">
            </a>
            <h1>
                <?php echo $controller->getTitle(); ?>
            </h1>
            <div style="margin: 0 0 0 30px">
                <p class="headerLink"><a href=<?php echo $controller->getUrl("index.php?controller=azubiTeam") ?>> Azubi Team </a> | </p>
                <p class="headerLink"><a href=<?php echo $controller->getUrl("index.php?controller=azubiList") ?>> Azubi Liste </a> | </p>
                <p class="headerLink"><a href=<?php echo $controller->getUrl("index.php?controller=addAzubi") ?>> Azubi hinzufügen </a></p>
            </div>
            <div class="clear"></div>
            <hr>