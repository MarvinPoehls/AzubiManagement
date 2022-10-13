<?php
$azubis = $controller->getAzubiData();
?>
<form class="searchbar" action="<?php echo $controller->getUrl("index.php") ?>" method="post">
    <input class="searchButton" type="submit" value="">
    <input type="hidden" name="controller" value="azubiList">
    <input type="hidden" name="listSize" value="<?php echo $controller->getListSize() ?>">
    <input type="hidden" name="startpoint" value="<?php echo $controller->getStartpoint() ?>">
    <input class="search" name="filter" type="search" placeholder="Search..">
</form>
<br>
<form action="<?php echo $controller->getUrl("index.php") ?>" method="post">
    <input type="hidden" name="controller" value="azubiList">
    <table class="azubiTable">
        <tr>
            <td class="tableHeader"></td>
            <td class="tableHeader">Name</td>
            <td class="tableHeader">Geburtstag</td>
            <td class="tableHeader">Email</td>
            <td class="tableHeader"></td>
        </tr>
        <?php foreach ($azubis as $azubi) { ?>
            <tr>
                <td class="tableCheckbox"><input type="checkbox" name="<?php echo $azubi->getId() ?>"></td>
                <td class="tableData"><?php echo $azubi->getName() ?></td>
                <td class="tableData"><?php echo $azubi->getBirthday() ?></td>
                <td class="tableData"><?php echo $azubi->getEmail() ?></td>
                <td class="tableButtons">
                    <a href="<?php echo $controller->getUrl("index.php?controller=addAzubi&azubiId=" . $azubi->getId()) ?>">
                        <img class='editButton' src='https://cdn-icons-png.flaticon.com/512/84/84380.png' alt='edit'>
                    </a>
                    <a href="<?php echo $controller->getUrl("index.php?controller=azubiList&deleteId=" . $azubi->getId() . "&action=delete") ?>">
                        <img class='deleteButton' src='https://cdn-icons-png.flaticon.com/512/1345/1345874.png' alt='edit'>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="clear"></div>
    <div>
        <input class="deleteUserButton" type="submit" value="Ausgewählte Azubis löschen">
        <input type="hidden" name="action" value="deleteAllChecked">
        <a href="<?php echo $controller->getUrl("index.php?controller=addAzubi") ?>">
            <input class="newUserButton" type="button" value="Neuen Azubi anlegen">
        </a>
    </div>
    <div class="clear"></div>
    <div class="pagination">
        <?php if ($controller->getStartpoint() != 0) { ?>
            <a href="<?php echo $controller->getUrl("index.php?controller=".$controller->getView()."&startpoint=".($controller->getStartpoint() - $this->getListSize())."&listSize=".$this->getListSize())?>">
                <img class="paginationArrow" src='https://d29fhpw069ctt2.cloudfront.net/icon/image/39092/preview.png' alt='vor'>
            </a>
        <?php } ?>
        <?php for ($i = 0; $i < $controller->countIds() / $this->getListSize(); $i++) { ?>
            <a href='<?php echo $controller->getUrl("index.php?controller=".$controller->getView()."&startpoint=".($i * $this->getListSize())."&listSize=".$this->getListSize()) ?>'>
                <input class='paginationButton' name='startingpoint' type='button' value='<?php echo ($i + 1) ?>'>
            </a>
        <?php } ?>
        <?php if ($controller->getStartpoint() < $controller->countIds() - $this->getListSize()) { ?>
            <a href="<?php echo $controller->getUrl("index.php?controller=".$controller->getView()."&startpoint=".($controller->getStartpoint() + $this->getListSize())."&listSize=".$this->getListSize())?>">
                <img class="paginationArrow" src='https://d29fhpw069ctt2.cloudfront.net/icon/image/39093/preview.png' alt='vor'>
            </a>
        <?php } ?>
    </div>
</form>
<form action="<?php echo $controller->getUrl("index.php") ?>" method="post">
    <input type="hidden" name="controller" value="azubiList">
    <div class="listSizeMenu">
        <label for="listSize">Tabellengröße: </label>
        <select id="listSize" name="listSize">
            <?php foreach ($controller->getSizes() as $size) { ?>
                <option value="<?php echo $size; ?>" <?php if($size == $controller->getListSize()){ echo "selected"; } ?>>
                    <?php echo $size; ?>
                </option>
            <?php } ?>
        </select>
        <input class="submitSize" type="submit" value="-">
    </div>
</form>
