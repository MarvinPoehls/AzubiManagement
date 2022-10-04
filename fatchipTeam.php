<?php
    include "functions.php";
    $conn = getDatabaseConnection();
    include "header.php";
    include "loginCheck.php";

    $sqlPath = "SELECT * FROM azubi";
    $result = mysqli_query($conn, $sqlPath);
    $azubiData = mysqli_fetch_all($result,MYSQLI_ASSOC);

    $title = "Azubi Team";
            foreach($azubiData as $azubi) {
?>
                <a class="profilLink" href="<?php echo getUrl("fatchipSite.php") ?>.?id=<?php echo $azubi["id"] ?>">
                    <div class="profil">
                        <img class="coworkerFoto" src="<?php echo $azubi["pictureurl"] ?>" alt="Mitarbeiter Foto">
                        <p class="profilName"><?php echo $azubi["name"] ?></p>
                        <hr>
                        <p>Geb.: <?php echo $azubi["birthday"] ?></p>
                        <p>Joined: <?php echo $azubi["employmentstart"] ?></p>
                        <p class="email">Email: <a href="mailto:"<?php echo $azubi["email"] ?>><?php echo $azubi["email"] ?></a></p>
                        <p>GitHub: <?php echo $azubi["githubuser"] ?></p>
                    </div>
                </a>
            <?php
                }
                include "footer.php";
                mysqli_close($conn);
            ?>
