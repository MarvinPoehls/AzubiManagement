<?php
$azubi = $controller->getAzubi();
?>
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-3 text-center">
            <img class="img-fluid" src="<?php echo $controller->getPictureUrl($azubi->getPictureurl()) ?>" alt="Mitarbeiter Foto">
        </div>
        <div class="col-sm-12 col-md-9">
            <h1><?php echo $azubi->getName(); ?></h1>
            <p>Azubi zum Fachinformatiker für Anwendungsentwicklung</p>
            <p>Geb.: <?php echo $azubi->getBirthday(); ?></p>
            <p>
                Email: <a href="mailto:"<?php echo $azubi->getEmail(); ?>><?php echo $azubi->getEmail(); ?></a>
            </p>
            <p>
                GitHub: <a href="https://github.com/<?php echo $azubi->getGithubuser(); ?>" target="_blank"><?php echo $azubi->getGithubuser(); ?></a>
            </p>
            <p> <?php echo $controller->atFatchipSince(1, 9, 2022); ?> </p>
        </div>
    </div>
    <div class="row mt-3">
        <hr>
        <div class="col-12">
            <ol>
                <?php if (!empty($azubi->getPreSkills())) { ?>
                    <p><u>Vorkenntnisse in Programmierung:</u></p>
                    <?php foreach ($azubi->getPreSkills() as $skill) { ?>
                        <li><?php echo $skill; ?></li>
                    <?php } ?>
                <?php } ?>
            </ol>
        </div>
        <?php if (!empty($azubi->getPreSkills()) && !empty($azubi->getNewSkills())) { ?>
            <hr>
        <?php } ?>
        <div class="col-12">
            <ul>
                <?php if (!empty($azubi->getNewSkills())) { ?>
                    <p><u>Bei Fatchip bisher gelernt:</u></p>
                    <?php foreach ($azubi->getNewSkills() as $skill) { ?>
                        <li><?php echo $skill ?></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
        <?php if (!empty($azubi->getPreSkills()) && empty($azubi->getNewSkills())) { ?>
            <hr>
        <?php } ?>
    </div>
<div class="float-end">
    <p onload="setTime()" id="time"></p>
</div>
<script src = "js/refreshTime.js"></script>