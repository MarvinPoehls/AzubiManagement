<?php
    include "functions.php";
    include "header.php";
    include "loginCheck.php";
    include "classes/Azubi.php";
    $title = "Azubi Team";

    $sqlPath = "SELECT id FROM azubi";
    $result = mysqli_query(DatabaseConnection::getConnection(), $sqlPath);
    while ($row = mysqli_fetch_row($result)) {
        $azubiIds[] = $row[0];
    }
    $azubiList = [];
    foreach ($azubiIds as $id){
        $azubiList[] = new Azubi($id);
    }
            foreach ($azubiList as $azubi) {
?>
                <a class="profilLink" href="<?php echo getUrl("fatchipSite.php") ?>.?id=<?php echo $azubi->getId() ?>">
                    <div class="profil">
                        <img class="coworkerFoto" src="<?php echo $azubi->getPictureurl() ?>" alt="Mitarbeiter Foto">
                        <p class="profilName"><?php echo $azubi->getName() ?></p>
                        <hr>
                        <p>Geb.: <?php echo $azubi->getBirthday() ?></p>
                        <p>Joined: <?php echo $azubi->getEmploymentstart() ?></p>
                        <p class="email">Email: <a href="mailto:"<?php echo $azubi->getEmail() ?>><?php echo $azubi->getEmail() ?></a></p>
                        <p>GitHub: <?php echo $azubi->getGithubuser() ?></p>
                    </div>
                </a>
            <?php
                }
                include "footer.php";
            ?>
