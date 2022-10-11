<?php
include "autoloader.php";
$website = new AzubiTeam();
include "header.php";
$azubiList = $website->getAzubiList();

foreach ($azubiList as $azubi) {
    ?>
    <a class="profilLink" href="<?php
    echo $website->getUrl("fatchipSite.php") ?>.?id=<?php
    echo $azubi->getId() ?>">
        <div class="profil">
            <img class="coworkerFoto" src="<?php
            echo $azubi->getPictureurl() ?>" alt="Mitarbeiter Foto">
            <p class="profilName"><?php
                echo $azubi->getName() ?></p>
            <hr>
            <p>Geb.: <?php
                echo $azubi->getBirthday() ?></p>
            <p>Joined: <?php
                echo $azubi->getEmploymentstart() ?></p>
            <p class="email">Email: <a href="mailto:"<?php
                echo $azubi->getEmail() ?>><?php
                    echo $azubi->getEmail() ?></a></p>
            <p>GitHub: <?php
                echo $azubi->getGithubuser() ?></p>
        </div>
    </a>
    <?php
}
include "footer.php";
?>
