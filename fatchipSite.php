<?php

include "functions.php";
include "header.php";
include "loginCheck.php";
include "classes/Azubi.php";

$id = getRequestParameter("id", 2);
$azubi = new Azubi($id);

$title = $azubi->getName();
$headline = "Azubi";

function getPictureUrl($url)
{
    if (empty($url)) {
        return "https://secure.gravatar.com/avatar/cb665e6a65789619c27932fc7b51f8dc?default=mm&size=200&rating=G";
    }
    return $url;
}

function atFatchipSince($startDay, $startMonth, $startYear)
{
    $day = date("d") - $startDay;
    if ($day < 0) {
        $day = 30 - $day;
    }
    $month = date("m");
    if ($month < $startMonth) {
        $month = date("m") + (12 - $startMonth);
    } else {
        $month = date("m") - $startMonth;
    }
    $year = date("Y") - $startYear;
    if ($month > $startMonth && $year != 0) {
        $year -= 1;
    }

    if ($year == 0 && $month == 0) {
        return "Bei Fatchip angestellt seit " . $day . " Tagen.";
    }
    if ($year == 0) {
        return "Bei Fatchip angestellt seit " . $day . " Tagen und " . $month . " Monaten.";
    }
    return "Bei Fatchip angestellt seit " . $day . " Tagen, " . $month . " Monaten und " . $year . " Jahren.";
}

?>
    <div class="foto">
        <img src="<?php
        echo getPictureUrl($azubi->getPictureurl()) ?>" alt="Mitarbeiter Foto">
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
            echo atFatchipSince(1, 9, 2022); ?> </p>
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