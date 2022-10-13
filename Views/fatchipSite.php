<?php
$azubi = $controller->getAzubi();
?>
    <div class="foto">
        <img src="<?php echo $controller->getPictureUrl($azubi->getPictureurl()) ?>" alt="Mitarbeiter Foto">
    </div>
    <div class=info>
        <h1><?php echo $azubi->getName(); ?></h1>
        <p class="job">Azubi zum Fachinformatiker für Anwendungsentwicklung</p>
        <p class="birthday">Geb.: <?php echo $azubi->getBirthday(); ?></p>
        <p class="email">
            Email: <a href="mailto:"<?php echo $azubi->getEmail(); ?>><?php echo $azubi->getEmail(); ?></a>
        </p>

        <p class="github">
            GitHub: <a href="https://github.com/<?php echo $azubi->getGithubuser(); ?>" target="_blank"><?php echo $azubi->getGithubuser(); ?></a>
        </p>
        <p> <?php echo $controller->atFatchipSince(1, 9, 2022); ?> </p>
    </div>
    <div class="clear"></div>
    <div class="knowledge">
        <hr class="strongHr">
        <ol>
            <?php if (!empty($azubi->getPreSkills())) { ?>
                <p>Vorkenntnisse in Programmierung:</p>
                <?php foreach ($azubi->getPreSkills() as $skill) { ?>
                    <li><?php echo $skill; ?></li>
                <?php } ?>
            <?php } ?>
        </ol>
        <?php if (!empty($azubi->getPreSkills()) && !empty($azubi->getNewSkills())) { ?>
            <hr>
        <?php } ?>
        <ul class="learned">
            <?php if (!empty($azubi->getNewSkills())) { ?>
                <p>Bei Fatchip bisher gelernt:</p>
                <?php foreach ($azubi->getNewSkills() as $skill) { ?>
                    <li><?php echo $skill ?></li>
                <?php } ?>
            <?php } ?>
        </ul>
        <?php if (!empty($azubi->getPreSkills()) && empty($azubi->getNewSkills())) { ?>
            <hr class='strongHr'>
        <?php } ?>
        <div class="date">
            <?php echo $controller->getTime(); ?>
        </div>
    </div>