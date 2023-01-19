<form action="<?php echo $controller->getUrl("index.php") ?>" method="post">
    <div class="row">
        <div class="col-0 col-md-3"></div>
        <div class="col-12 col-md-6">
            <div class="card p-5 my-5">
                <h2 class="mx-3">In Azubi Seite einloggen</h2>
                <div class="card-body">
                    <label class="form-label" for="email"> Email: </label>
                    <input class="form-control mb-5" id="email" name="email" type="email" value="">
                    <label class="form-label" for="password"> Passwort: </label>
                    <input class="form-control" id="password" name="password" type="text" value="">
                    <?php if ($controller->isDataWrong()) { ?>
                        <p class="text-warning my-2">Email oder Passwort inkorrekt!</p>
                    <?php } else { ?>
                        <p class="text-white">.</p>
                    <?php } ?>
                    <div class="text-center">
                        <input class="btn btn-primary mt-5 mb-4" type="submit" value="Weiter">
                    </div>
                    <input type="hidden" name="controller" value="login">
                    <input type="hidden" name="action" value="checkLogin">
                </div>
            </div>
        </div>
        <div class="col-0 col-md-3"></div>
    </div>
</form>
