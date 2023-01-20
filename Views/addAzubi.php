<?php
    $azubi = $controller->getAzubi();
?>

<form action="<?php echo $controller->getUrl("index.php") ?>" method="get">
    <input type="hidden" name="azubiId" value="<?php echo $azubi->getId() ?>">
    <input type="hidden" name="controller" value="AddAzubi">
    <input type="hidden" name="action" value="save">
    <div class="row">
        <div class="col-xl-5 col-sm-11">
            <div class="my-4">
                <label class="form-label" for="name">Vor- und Nachname: </label>
                <p><input class="form-control" id="name" name="name" type="text" value="<?php echo $azubi->getName() ?>"></p>
            </div>
            <div class="my-4">
                <label class="form-label" for="birthday">Geburtstag: </label>
                <p><input class="form-control" id="birthday" name="birthday" type="date" value="<?php echo $azubi->getBirthday() ?>"></p>
            </div>
            <div class="my-4">
                <label class="form-label" for="email">Email: </label>
                <p><input class="form-control" id="email" name="email" type="email" placeholder="example@email.com" value="<?php echo $azubi->getEmail() ?>"></p>
            </div>
            <div class="my-4">
                <label class="form-label" for="github">Github: </label>
                <p><input class="form-control" id="github" name="githubuser" type="text" value="<?php echo $azubi->getGithubuser() ?>"></p>
            </div>
            <div class="my-4">
                <label class="form-label" for="employmentstart">Ausbilungsanfang: </label>
                <p><input class="form-control" id="employmentstart" name="employmentstart" type="date" value="<?php echo $azubi->getEmploymentstart() ?>"></p>
            </div>
            <div class="my-4">
                <label class="form-label" for="picture">Bild URL: </label>
                <p><input class="form-control" id="picture" name="pictureurl" type="text" value="<?php echo $azubi->getPictureurl() ?>"></p>
            </div>
        </div>
        <div class="col-xl-2 col-sm-0"></div>
        <div class="col-xl-5 col-sm-11">
            <div>
                <div class="my-4">
                    <label class="form-label" for="password"> Passwort: </label>
                    <p><input class="form-control" id="password" name="password" type="text" value=""></p>
                </div>
                <div class="my-4">
                    <label class="form-label" for="repeatPassword">Passwort wiederholen: </label>
                    <p><input class="form-control" id="repeatPassword" name="repeatPassword" type="text" value=""></p>
                </div>
            </div>
            <div>
                <div>
                    <div id="preSkills">
                        <label class="form-label" for="pre"> Pre Skills: </label>
                        <?php if (count($azubi->getNewSkills()) === 0) { ?>
                            <div class="row my-2" id="<?php echo "pre." . $id = uniqid() ?>">
                                <div class="col-10">
                                    <input name="preSkills[]" class="form-control" type="text">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-danger" type="button" onclick="deleteSkill(<?php echo "'pre.".$id."'" ?>)">
                                        <i class="bi bi-dash-circle"></i>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                        <?php foreach ($azubi->getPreSkills() as $skill) {?>
                            <div class="row my-2" id="<?php echo "pre." . $id = uniqid() ?>">
                                <div class="col-10">
                                    <input name="preSkills[]" class="form-control" type="text" value=<?php echo $skill ?>>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-danger" type="button" onclick="deleteSkill(<?php echo "'pre.".$id."'" ?>)">
                                        <i class="bi bi-dash-circle"></i>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <button id="addPreSkill" type="button" class="btn btn-success mt-2"><i class="bi bi-plus-circle"></i></button>
                </div>
                <div class="my-5">
                    <div id="newSkills">
                        <label class="form-label" for="new">Neue Skills: </label>
                        <?php if (count($azubi->getNewSkills()) === 0) { ?>
                            <div class="row my-2" id="<?php echo "new." . $id = uniqid() ?>" >
                                <div class="col-10">
                                    <input name="newSkills[]" class="form-control" type="text">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-danger" type="button" onclick="deleteSkill(<?php echo "'new.".$id."'" ?>)">
                                        <i class="bi bi-dash-circle"></i>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                        <?php foreach ($azubi->getNewSkills() as $skill) {?>
                            <div class="row my-2" id="<?php echo "new." . $id = uniqid() ?>">
                                <div class="col-10">
                                    <input name="newSkills[]" class="form-control" type="text" value=<?php echo $skill ?>>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-danger" type="button" onclick="deleteSkill(<?php echo "'new.".$id."'" ?>)">
                                        <i class="bi bi-dash-circle"></i>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <button id="addNewSkill" type="button" class="btn btn-success mt-2"><i class="bi bi-plus-circle"></i></button>
                </div>
            </div>
        </div>
    </div>
    <input class="btn btn-primary mb-2" type="submit" value="Speichern">
    <input type="hidden" name="action" value="save">
</form>
<div class="clear"></div>
<form action="<?php echo $controller->getUrl("index.php") ?>" method="post">
    <input class="btn btn-primary" type="submit" value="Löschen">
    <input type="hidden" name="action" value = "delete">
    <input type="hidden" name="controller" value = "AddAzubi">
    <input type="hidden" name="deleteId" value = "<?php echo $azubi->getId() ?>">
</form>
<script src="js/addAzubi.js"></script>