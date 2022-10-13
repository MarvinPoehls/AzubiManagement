<?php
    $azubi = $controller->getAzubi();
?>

<form action="<?php echo $controller->getUrl("index.php") ?>" method="post">
    <input type="hidden" name="azubiId" value="<?php echo $azubi->getId() ?>">
    <input type="hidden" name="controller" value="AddAzubi">
    <input type="hidden" name="action" value="save">
    <div class="dataDiv">
        <div class="inputData">
            <label for="name">Vor- und Nachname: </label>
            <p><input id="name" name="name" type="text" value="<?php echo $azubi->getName() ?>"></p>
        </div>
        <div class="inputData">
            <label for="birthday">Geburtstag: </label>
            <p><input id="birthday" name="birthday" type="date" value="<?php echo $azubi->getBirthday() ?>"></p>
        </div>
        <div class="inputData">
            <label for="email">Email: </label>
            <p><input id="email" name="email" type="email" value="<?php echo $azubi->getEmail() ?>"></p>
        </div>
        <div class="inputData">
            <label for="github">Github: </label>
            <p><input id="github" name="githubuser" type="text" value="<?php echo $azubi->getGithubuser() ?>"></p>
        </div>
        <div class="inputData">
            <label for="employmentstart">Ausbilungsanfang: </label>
            <p><input id="employmentstart" name="employmentstart" type="date" value="<?php echo $azubi->getEmploymentstart() ?>"></p>
        </div>
        <div class="inputData">
            <label for="picture">Bild URL: </label>
            <p><input id="picture" name="pictureurl" type="text" value="<?php echo $azubi->getPictureurl() ?>"></p>
        </div>
            <p><input class="submit" type="submit" value="Speichern"></p>
            <input type="hidden" name="mode" value="save">
    </div>
    <div class="skillDiv">
        <div class="inputData">
            <label for="pre"> Pre Skills: </label>
            <p><input id="pre" name="pre" type="text" value="<?php echo $azubi->getPreSkills(true) ?>"></p>
        </div>
        <div class="inputData">
            <label for="new">Neue Skills: </label>
            <p><input id="new" name="new" type="text" value="<?php echo $azubi->getNewSkills(true) ?>"></p>
        </div>
    </div>
    <div class="passwordDiv">
        <div class="inputData">
            <label for="password"> Passwort: </label>
            <p><input id="password" name="password" type="text" value=""></p>
        </div>
        <div class="inputData">
            <label for="repeatPassword">Passwort wiederholen: </label>
            <p><input id="repeatPassword" name="repeatPassword" type="text" value=""></p>
        </div>
    </div>
</form>
<div class="clear"></div>
<form class="delete" action="index.php" method="post">
    <p><input class="submit" type="submit" value="Löschen"></p>
    <input type="hidden" name="action" value = "delete">
    <input type="hidden" name="controller" value = "AddAzubi">
    <input type="hidden" name="deleteId" value = "<?php echo $azubi->getId() ?>">
</form>
<div class="clear"></div>
<br> <br>
