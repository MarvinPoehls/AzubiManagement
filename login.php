<?php

$title = "Login";
include "functions.php";
include "header.php";
include "classes/Azubi.php";

$email = getRequestParameter("email");
$password = getRequestParameter("password");
$isDataWrong = false;

session_start();

if ($email !== false && $password !== false) {
    if (DatabaseConnection::isEntryValid($email, "email")) {
        $sql = "SELECT password FROM azubi WHERE email = '".$email."'";
        $result = DatabaseConnection::executeMysqlQuery($sql);
        $row = mysqli_fetch_row($result);
        $userPassword = $row[0];

        if (Azubi::encrypt($password) == $userPassword) {
            $_SESSION["lastLogin"] = time();
            $lastSite = $_SESSION["lastSite"];
            redirect($lastSite);
        } else {
            $isDataWrong = true;
        }
    } else {
        $isDataWrong = true;
    }
}

?>
<form class="loginForm" action="<?php echo getUrl("login.php") ?>" method="post">
    <h2>In Azubi Seite einloggen</h2>
    <div class="loginInput">
        <label for="user"> Email: </label>
        <p><input id="email" name="email" type="email" value=""></p>
        <label for="password"> Passwort: </label>
        <p><input id="password" name="password" type="text" value=""></p>
    </div>
    <?php if ($isDataWrong) { ?>
        <p class="errorMessage" >Email oder Passwort inkorrekt!</p>
    <?php } ?>
    <input class="submitLogin" type="submit" value="Weiter">
</form>

<?php include "footer.php" ?>
