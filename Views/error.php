<div class="card bg-danger text-dark">
    <div class="card-header">
        ERROR
    </div>
    <div class="card-body">
        <p class="card-text">Message: <?php echo $controller->getException()->getMessage(); ?></p>
    </div>
</div>