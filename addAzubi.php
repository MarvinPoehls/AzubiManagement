<?php
    $title = "Azubi hinzufügen";
    include "header.php";
    include "loginCheck.php";
    $azubiId = getRequestParameter("azubiId");

    if(getRequestParameter("deleteId") !== false){
        deleteData(getRequestParameter("deleteId"));
    } elseif (getRequestParameter("name")) {
        $azubiData = ["name" => getRequestParameter("name"),
            "birthday" => getRequestParameter("birthday"),
            "email" => getRequestParameter("email"),
            "githubuser" => getRequestParameter("githubuser"),
            "employmentstart" => getRequestParameter("employmentstart"),
            "pictureurl" => getRequestParameter("pictureurl"),
            "password" => encrypt(getRequestParameter("password"))];
        $azubiPreSkills = explode(",", getRequestParameter("pre"));
        $azubiNewSkills = explode(",", getRequestParameter("new"));

        if (!empty($azubiId)) {
            updateData($azubiId, $azubiData, $azubiPreSkills, $azubiNewSkills);
        } else {
            insertData($azubiData,$azubiPreSkills, $azubiNewSkills);
        }
    }

    $azubiSkills = ["pre" => "","new" => ""];

    $azubiData = array("name" => "", "birthday" => "", "email" => "", "githubuser" => "", "employmentstart" => "", "pictureurl" => "");

    if(!empty($azubiId)){
        $azubiData = loadUser($azubiId);
        $azubiSkills["pre"] = loadSkills($azubiId, "pre");
        $azubiSkills["new"] = loadSkills($azubiId, "new");
    }


?>

<form action="<?php echo getUrl("addAzubi.php") ?>" method="post">
    <input type="hidden" name="azubiId" value="<?php echo $azubiId ?>">
    <div class="dataDiv">
        <div class="inputData">
            <label for="name">Vor- und Nachname: </label>
            <p><input id="name" name="name" type="text" value="<?php echo $azubiData["name"] ?>"></p>
        </div>
        <div class="inputData">
            <label for="birthday">Geburtstag: </label>
            <p><input id="birthday" name="birthday" type="date" value="<?php echo $azubiData["birthday"] ?>"></p>
        </div>
        <div class="inputData">
            <label for="email">Email: </label>
            <p><input id="email" name="email" type="email" value="<?php echo $azubiData["email"] ?>"></p>
        </div>
        <div class="inputData">
            <label for="github">Github: </label>
            <p><input id="github" name="githubuser" type="text" value="<?php echo $azubiData["githubuser"] ?>"></p>
        </div>
        <div class="inputData">
            <label for="employmentstart">Ausbilungsanfang: </label>
            <p><input id="employmentstart" name="employmentstart" type="date" value="<?php echo $azubiData["employmentstart"] ?>"></p>
        </div>
        <div class="inputData">
            <label for="picture">Bild URL: </label>
            <p><input id="picture" name="pictureurl" type="text" value="<?php echo $azubiData["pictureurl"] ?>"></p>
        </div>
            <p><input class="submit" type="submit" value="Speichern"></p>
            <input type="hidden" name="mode" value="save">
    </div>
    <div class="skillDiv">
        <div class="inputData">
            <label for="pre"> Pre Skills: </label>
            <p><input id="pre" name="pre" type="text" value="<?php echo $azubiSkills["pre"] ?>"></p>
        </div>
        <div class="inputData">
            <label for="new">Neue Skills: </label>
            <p><input id="new" name="new" type="text" value="<?php echo $azubiSkills["new"] ?>"></p>
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
    <input type="hidden" name="deleteId" value = "<?php echo $azubiId ?>">
</form>
<div class="clear"></div>
<br> <br>

<?php include "footer.php" ?>
