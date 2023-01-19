<div class="row" >
    <?php foreach ($controller->getAzubiList() as $azubi) { ?>
        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-12 my-3 d-grid">
            <div class="card float-start shadow-sm p-3 mb-5 bg-body rounded">
                <div class="col-12">
                    <img width="200" height="200" class="card-img-top img-fluid rounded" src="<?php echo $azubi->getPictureurl() ?>" alt="Mitarbeiter Foto">
                </div>
                <div class="col-12 card-body">
                    <div class="py-2">
                        <h5 class="card-title border-bottom"><?php echo $azubi->getName() ?></h5>
                    </div>
                    <p>Geb.: <?php echo $azubi->getBirthday() ?></p>
                    <p>Joined: <?php echo $azubi->getEmploymentstart() ?></p>
                    <p>Email: <a href="mailto:"<?php echo $azubi->getEmail() ?>><?php echo $azubi->getEmail() ?></a></p>
                    <p>GitHub: <a href="https://github.com/<?php echo $azubi->getGithubuser() ?>"><?php echo $azubi->getGithubuser() ?></a></p>
                    <a class="btn btn-primary" href="<?php echo $controller->getUrl("index.php?controller=AzubiSite&id=".$azubi->getId())?>">
                        Mehr
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>