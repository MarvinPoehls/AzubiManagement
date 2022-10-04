<?php

include "functions.php";
$conn = getDatabaseConnection();
include "header.php";
include "loginCheck.php";

$azubiIds = [];
$azubiData = [];
$azubiPreSkills = [];
$azubiNewSkills = [];


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = getRequestParameter("id",2);

$sqlPath = "SELECT * FROM azubi WHERE id =" . $id;
$result = mysqli_query($conn, $sqlPath);
$azubiData = mysqli_fetch_assoc($result);

$azubiPreSkills = getAzubiSkillsByType($conn, $id ,'pre');

$azubiNewSkills = getAzubiSkillsByType($conn, $id ,'new');

mysqli_close($conn);

function getPictureUrl($url){
    if(empty($url)){
        return "https://secure.gravatar.com/avatar/cb665e6a65789619c27932fc7b51f8dc?default=mm&size=200&rating=G";
    }
    return $url;
}

function atFatchipSince($startDay, $startMonth, $startYear)
{
    $day = date("d") - $startDay;
    if($day < 0){
        $day = 30 - $day;
    }
    $month = date("m");
    if ($month < $startMonth) {
        $month = date("m") + (12 - $startMonth);
    } else {
        $month = date("m") - $startMonth;
    }
    $year = date("Y") - $startYear;
    if($month > $startMonth && $year != 0){
        $year-=1;
    }

    if ($year == 0 && $month == 0) {
        return "Bei Fatchip angestellt seit " . $day . " Tagen.";
    }
    if ($year == 0) {
        return "Bei Fatchip angestellt seit " . $day . " Tagen und " . $month . " Monaten.";
    }
    return "Bei Fatchip angestellt seit " . $day . " Tagen, " . $month . " Monaten und " . $year . " Jahren.";
}

$title = $azubiData["name"];
$headline = "Azubi";

?>
            <div class="foto">
                <img src="<?php echo getPictureUrl($azubiData["pictureurl"])?>" alt="Mitarbeiter Foto">
            </div>
            <div class = info>
                <h1><?php echo $azubiData["name"] ?></h1>
                <p class="job">Azubi zum Fachinformatiker für Anwendungsentwicklung</p>
                <p class="birthday">Geb.: <?php echo $azubiData["birthday"] ?></p>
                <p class="email">
                    Email:
                    <a href="mailto:"<?php echo $azubiData["email"] ?>><?php echo $azubiData["email"] ?></a>
                </p>

                <p class="github">
                    GitHub:
                    <a href="https://github.com/<?php echo $azubiData["githubuser"] ?>" target="_blank"><?php echo $azubiData["githubuser"] ?></a>
                </p>
                <p> <?php echo atFatchipSince(1,9,20); ?> </p>
            </div>
            <div class="clear"></div>
            <div class="knowledge">
                <hr class="strongHr">
                <ol>
                    <?php
                        if (count($azubiPreSkills)  > 0) {
                            echo "<p>Vorkenntnisse in Programmierung:</p>";
                            foreach ($azubiPreSkills as $skill){
                                echo "<li>". $skill["skill"] ."</li>";
                            }
                        }
                    ?>
                </ol>
                <?php
                    if(count($azubiPreSkills) != 0 && count($azubiNewSkills) != 0){
                        echo "<hr>";
                    }
                ?>
                <ul class="learned">
                    <?php
                        if (count($azubiNewSkills)  > 0) {
                            echo "<p>Bei Fatchip bisher gelernt:</p>";
                            foreach ($azubiNewSkills as $skill){
                                echo "<li>". $skill["skill"] ."</li>";
                            }
                        }
                    ?>
                </ul>
                <?php
                if(count($azubiPreSkills) != 0 && count($azubiNewSkills) != 0){
                    echo "<hr class='strongHr'>";
                }
                ?>
                <div class="date">
                    <?php echo date("d.m.Y") . " - " . date("H:i") . " Uhr" ?>
                </div>
            </div>
<?php include "footer.php"?>