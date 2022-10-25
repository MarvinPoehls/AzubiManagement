<div class="error">
    <h1>ERROR</h1>
    <hr>
    <p>Message: <?php echo $exception->getMessage(); ?></p>
    <p>File: <?php echo $exception->getFile(); ?></p>
    <p>Line: <?php echo $exception->getLine(); ?></p>
</div>