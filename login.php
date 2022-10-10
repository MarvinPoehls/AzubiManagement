<?php
include "functions.php";
$website = new Login();
include "header.php";
$isDataWrong = $website->checkLogin();
?>
<form class="loginForm" action="<?php
echo $website->getUrl("login.php") ?>" method="post">
    <h2>In Azubi Seite einloggen</h2>
    <div class="loginInput">
        <label for="email"> Email: </label>
        <p><input id="email" name="email" type="email" value=""></p>
        <label for="password"> Passwort: </label>
        <p><input id="password" name="password" type="text" value=""></p>
    </div>
    <?php
    if ($isDataWrong) { ?>
        <p class="errorMessage">Email oder Passwort inkorrekt!</p>
    <?php
    } ?>
    <input class="submitLogin" type="submit" value="Weiter">
</form>

<?php
include "footer.php" ?>
