<?php
$azubis = $controller->getAzubiData();
?>
<div class="mb-3">
    <form action="<?php echo $controller->getUrl("index.php") ?>" method="get" id="searchForm">
        <input type="hidden" name="controller" value="azubiList">
        <input type="hidden" name="listSize" value="<?php echo $controller->getListSize() ?>">
        <input type="hidden" name="startpoint" value="<?php echo $controller->getStartpoint() ?>">
        <div class="row my-2">
            <div class="col-sm-1 col-md-2 col-3">
                <input class="btn btn-dark float-start" type="submit" value="Search">
            </div>
            <div class="col-sm-11 col-md-10 col-9" id="searchBox">
                <input class="form-control float-end" id="search" value="<?php echo $controller->getFilter(); ?>" onfocus="autofill()" oninput="autofill()" name="filter" type="search" placeholder="Search.." autocomplete="off">
                <div class="mt-5 border border-light bg-white rounded position-absolute float-end w-50" id="suggestions"></div>
            </div>
        </div>
    </form>
</div>
<form action="<?php echo $controller->getUrl("index.php") ?>" method="post">
    <input type="hidden" name="controller" value="azubiList">
    <div class="row">
        <div class="col-12">
            <table id="azubiTable" class="table table-striped border-top border-bottom border-end">
                <tr class="table-dark">
                    <th></th>
                    <th>Name</th>
                    <th>Geburtstag</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                <?php foreach ($azubis as $azubi) { ?>
                    <tr id="<?php echo $azubi->getId() ?>">
                        <td><input type="checkbox" name="<?php echo $azubi->getId() ?>"></td>
                        <td><?php echo $azubi->getName() ?></td>
                        <td><?php echo $azubi->getBirthday() ?></td>
                        <td><?php echo $azubi->getEmail() ?></td>
                        <td>
                            <button type="button" class="btn btn-danger float-end mx-2" onclick="deleteAzubi(<?php echo $azubi->getId() ?>)" id="delete"><i class="bi-trash text-dark"></i></button>
                            <a class="btn btn-success float-end" href="<?php echo $controller->getUrl("index.php?controller=addAzubi&azubiId=" . $azubi->getId()) ?>">
                                <i class="bi-pencil text-dark"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($controller->getStartpoint() != 0) { ?>
                <li class="page-item">
                    <a class="page-link text-dark" href="<?php echo $controller->getUrl("index.php?controller=".$controller->getView()."&startpoint=".($controller->getStartpoint() - $this->getListSize())."&listSize=".$this->getListSize())?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } ?>
            <?php for ($i = 0; $i < $controller->countIds() / $this->getListSize(); $i++) { ?>
                <li class="page-item"><a class="page-link text-dark" href="<?php echo $controller->getUrl("index.php?controller=".$controller->getView()."&startpoint=".($i * $this->getListSize())."&listSize=".$this->getListSize()) ?>"><?php echo ($i + 1) ?></a></li>
            <?php } ?>
            <?php if ($controller->getStartpoint() < $controller->countIds() - $this->getListSize()) { ?>
                <li class="page-item">
                    <a class="page-link text-dark" href="<?php echo $controller->getUrl("index.php?controller=".$controller->getView()."&startpoint=".($controller->getStartpoint() + $this->getListSize())."&listSize=".$this->getListSize())?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
    <div class="row">
        <div class="col-lg-3 col-7">
            <input class="btn btn-dark float-start my-2" type="submit" value="Ausgewählte Azubis löschen">
        </div>
        <input type="hidden" name="action" value="deleteAllChecked">
        <div class="col-lg-3 col-7">
            <a href="<?php echo $controller->getUrl("index.php?controller=addAzubi") ?>">
                <input class="btn btn-dark float-start my-2" type="button" value="Neuen Azubi anlegen">
            </a>
        </div>
    </div>
</form>
<form action="<?php echo $controller->getUrl("index.php") ?>" method="post" id="listSizeForm">
    <input type="hidden" name="controller" value="azubiList">
    <div>
        <label class="d-block" for="listSize">Tabellengröße: </label>
        <select onchange="submit('listSizeForm')" class="btn btn-dark float-start" id="listSize" name="listSize">
            <?php foreach ($controller->getSizes() as $size) { ?>
                <option value="<?php echo $size; ?>" <?php if($size == $controller->getListSize()){ echo "selected"; } ?>>
                    <?php echo $size; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <script src="js/azubiList.js"></script>
</form>