<?php

$title = "Azubi Liste";
include "functions.php";
include "header.php";
include "loginCheck.php";
include "classes/Azubi.php";


if (getRequestParameter("filter")) {
    $filter = getRequestParameter("filter");
} else {
    $filter = " ";
}

if (getRequestParameter("startpoint")) {
    $startpoint = getRequestParameter("startpoint");
} else{
    $startpoint = 0;
}

$listSize = getRequestParameter("listSize", 10);
$azubis = getAzubiData($filter, $listSize, $startpoint, DatabaseConnection::getConnection());

if (getRequestParameter("deleteId") !== false) {
    deleteData(getRequestParameter("deleteId"), DatabaseConnection::getConnection());
    header("Refresh:0; url=azubiList.php");
}

foreach ($azubis as $azubi){
    if (getRequestParameter($azubi->getId()) == "on") {
        deleteData($azubi->getId(), $azubi->getConn);
        header("Refresh:0; url=azubiList.php");
    }
}

?>
<form class="searchbar" action="<?php echo getUrl("azubiList.php") ?>" method="post">
    <input class="searchButton" type="submit" value="">
    <input class="search" name="filter" type="search" placeholder="Search..">
</form>
<br>
<form action="<?php echo getUrl("azubiList.php") ?>" method="post">
    <table class="azubiTable">
        <tr>
            <td class="tableHeader"></td>
            <td class="tableHeader">Name</td>
            <td class="tableHeader">Geburtstag</td>
            <td class="tableHeader">Email</td>
            <td class="tableHeader"></td>
        </tr>
        <?php foreach($azubis as $azubi) {?>
            <tr>
                <td class="tableCheckbox"><input type="checkbox" name="<?php echo $azubi->getId() ?>"></td>
                <td class="tableData"><?php echo $azubi->getName() ?></td>
                <td class="tableData"><?php echo $azubi->getBirthday() ?></td>
                <td class="tableData"><?php echo $azubi->getEmail() ?></td>
                <td class="tableButtons">
                    <a href="<?php echo getUrl("addAzubi.php?azubiId=".$azubi->getId()) ?>"><img class='editButton' src='https://cdn-icons-png.flaticon.com/512/84/84380.png' alt='edit'></a>
                    <a href="<?php echo getUrl("azubiList.php?deleteId=".$azubi->getId()) ?>"><img class='deleteButton' src='https://cdn-icons-png.flaticon.com/512/1345/1345874.png' alt='edit'></a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="clear"></div>
    <div>
        <input class="deleteUserButton" type="submit" value="Ausgewählte Azubis löschen">
        <a href="<?php echo getUrl("addAzubi.php") ?>"><input class="newUserButton" type="button" value="Neuen Azubi anlegen"></a>
    </div>
    <div class="clear"></div>
    <div class="pagination">
        <?php if ($startpoint != 0) { ?>
            <a href="<?php echo getUrl("azubiList.php") ?>.?startpoint=<?php echo $startpoint - $listSize ?>&listSize=<?php echo $listSize ?>"><img class="paginationArrow" src='https://d29fhpw069ctt2.cloudfront.net/icon/image/39092/preview.png' alt='vor'></a>
        <?php } ?>
        <?php
        for($i = 0; $i < count(getAllIds(DatabaseConnection::getConnection()))/$listSize; $i++){
            $start = $i * $listSize;
            $value = $i+1;
            ?>
            <a href='<?php echo getUrl("azubiList.php") ?>.?startpoint=<?php echo $start ?>&listSize=<?php echo $listSize ?>'><input class='paginationButton' name='startingpoint' type='button' value='<?php echo $value ?>'></a>
        <?php } ?>
        <?php if ($startpoint < count(getAllIds(DatabaseConnection::getConnection()))-$listSize) { ?>
            <a href="<?php echo getUrl("azubiList.php") ?>.?startpoint=<?php echo $startpoint + $listSize ?>&listSize=<?php echo $listSize ?>"><img class="paginationArrow" src='https://d29fhpw069ctt2.cloudfront.net/icon/image/39093/preview.png' alt='vor'></a>
        <?php } ?>
    </div>
</form>
<form action="<?php echo getUrl("azubiList.php") ?>" method="post">
    <div class="listSizeMenu">
        <select name="listSize">
            <option value="5">5</option>
            <option value="10" selected="selected">10</option>
            <option value="20">20</option>
        </select>
        <input class="submitSize" type="submit" value="-">
    </div>
</form>

<?php include "footer.php"; ?>
