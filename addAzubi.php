<?php
    include "functions.php";
    include "loginCheck.php";
    include "classes/Azubi.php";

    $id = getRequestParameter("azubiId");
    if(!$id){
        $azubi = new Azubi();
        $title = "Azubi hinzufügen";
    } else {
        $azubi = new Azubi($id);
        $title = "Azubi bearbeiten";
    }

    include "header.php";

    if(getRequestParameter("deleteId") !== false){
        $azubi->delete(getRequestParameter("deleteId"));
    } elseif (getRequestParameter("name")) {
        $azubi->setName(getRequestParameter("name"));
        $azubi->setBirthday(getRequestParameter("birthday"));
        $azubi->setEmail(getRequestParameter("email"));
        $azubi->setGithubuser(getRequestParameter("githubuser"));
        $azubi->setEmploymentstart(getRequestParameter("employmentstart"));
        $azubi->setPictureurl(getRequestParameter("pictureurl"));
        $azubi->setPreSkills(explode(",", getRequestParameter("pre")));
        $azubi->setNewSkills(explode(",", getRequestParameter("new")));
        $azubi->setPassword(getRequestParameter("password"));
        $azubi->save();
    }
?>

<form action="<?php echo getUrl("addAzubi.php") ?>" method="post">
    <input type="hidden" name="azubiId" value="<?php echo $azubi->getId() ?>">
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
<form class="delete" action="<?php echo getUrl("addAzubi.php") ?>" method="post">
    <p><input class="submit" type="submit" value="Löschen"></p>
    <input type="hidden" name="deleteId" value = "<?php echo $azubi->getId() ?>">
</form>
<div class="clear"></div>
<br> <br>

<?php include "footer.php" ?>
