<?php
    include "functions.php";

    $conn = getDatabaseConnection();

    $sqlPath = "SELECT * FROM azubi";
    $result = mysqli_query($conn, $sqlPath);
    $azubiData = mysqli_fetch_all($result,MYSQLI_ASSOC);

    $title = "Azubi Team";
    include "header.php";
    include "loginCheck.php";

            foreach($azubiData as $azubi) {
?>
                <a class="profilLink" href="http://localhost/fatchipSite.php?id=<?php echo $azubi["id"] ?>">
                    <div class="profil">
                        <img class="coworkerFoto" src="<?php echo $azubi["pictureurl"] ?>" alt="Mitarbeiter Foto">
                        <p class="profilName"><?php echo $azubi["name"] ?></p>
                        <hr>
                        <p>Geb.: <?php echo $azubi["birthday"] ?></p>
                        <p>Joined: <?php echo $azubi["employmentstart"] ?></p>
                        <p class="email">Email: <a href="mailto:marvinpoehls@fatchip.de"><?php echo $azubi["email"] ?></a></p>
                        <p>GitHub: <?php echo $azubi["githubuser"] ?></p>
                    </div>
                </a>
            <?php
                }
                include "footer.php";
                mysqli_close($conn);
            ?>
