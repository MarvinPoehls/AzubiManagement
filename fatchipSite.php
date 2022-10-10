<?php
include "functions.php";
$website = new AzubiSite();
include "header.php";
include "loginCheck.php";
$azubi = $website->getAzubi();
?>
    <div class="foto">
        <img src="<?php
        echo $website->getPictureUrl($azubi->getPictureurl()) ?>" alt="Mitarbeiter Foto">
    </div>
    <div class=info>
        <h1><?php
            echo $azubi->getName(); ?></h1>
        <p class="job">Azubi zum Fachinformatiker für Anwendungsentwicklung</p>
        <p class="birthday">Geb.: <?php
            echo $azubi->getBirthday(); ?></p>
        <p class="email">
            Email:
            <a href="mailto:"<?php
            echo $azubi->getEmail(); ?>><?php
                echo $azubi->getEmail(); ?></a>
        </p>

        <p class="github">
            GitHub:
            <a href="https://github.com/<?php
            echo $azubi->getGithubuser(); ?>" target="_blank"><?php
                echo $azubi->getGithubuser(); ?></a>
        </p>
        <p> <?php
            echo $website->atFatchipSince(1, 9, 2022); ?> </p>
    </div>
    <div class="clear"></div>
    <div class="knowledge">
        <hr class="strongHr">
        <ol>
            <?php
            if (!empty($azubi->getPreSkills())) {
                echo "<p>Vorkenntnisse in Programmierung:</p>";
                foreach ($azubi->getPreSkills() as $skill) {
                    echo "<li>" . $skill . "</li>";
                }
            }
            ?>
        </ol>
        <?php
        if (!empty($azubi->getPreSkills()) && !empty($azubi->getNewSkills())) {
            echo "<hr>";
        }
        ?>
        <ul class="learned">
            <?php
            if (!empty($azubi->getNewSkills())) {
                echo "<p>Bei Fatchip bisher gelernt:</p>";
                foreach ($azubi->getNewSkills() as $skill) {
                    echo "<li>" . $skill . "</li>";
                }
            }
            ?>
        </ul>
        <?php
        if (!empty($azubi->getPreSkills()) && empty($azubi->getNewSkills())) {
            echo "<hr class='strongHr'>";
        }
        ?>
        <div class="date">
            <?php
            echo date("d.m.Y") . " - " . date("H:i") . " Uhr" ?>
        </div>
    </div>
<?php
include "footer.php" ?>