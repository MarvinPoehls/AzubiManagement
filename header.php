<!DOCTYPE html>
<html>
<head>
    <title>Fatchip
        <?php
        if (!isset($title)) {
            $title = "Azubi Portal";
        }
        echo $title;
        ?>
    </title>
    <link rel="stylesheet" href=<?php
    echo getUrl("styles2.css") ?>>
</head>
<body>
<div class="mainContent">
    <a class="logo" href="https://www.fatchip.de/" target="_blank">
        <img src="https://www.tradebyte.io/wp-content/uploads/2020/12/fatchip_logo.png" alt="Fatchip Logo">
    </a>
    <h1>
        <?php
        if (!isset($headline)) {
            $headline = $title;
        }
        echo $headline;
        ?>
    </h1>
    <div style="margin: 0 0 0 30px">
        <p class="headerLink"><a href=<?php
            echo getUrl("addAzubi.php") ?>>Azubi hinzufügen</a> | </p>
        <p class="headerLink"><a href=<?php
            echo getUrl("azubiList.php") ?>>Azubi Liste </a> | </p>
        <p class="headerLink"><a href=<?php
            echo getUrl("fatchipTeam.php") ?>>Azubi Team</a></p>
    </div>
    <div class="clear"></div>
    <hr>