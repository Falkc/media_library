<?php $title = "Médiathèque - Passer à la phase des voeux"; ?>

<?php ob_start(); ?>
<div class="w-50 mx-auto">
    <h2 class="my-3 text-center">Sélectionner la date limite pour émettre des voeux</h2>

    <?php if (!empty($errorMsg)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $errorMsg ?>
        </div>
    <?php } else if (!empty($successMsg)) { ?>
        <div class="alert alert-success" role="success">
            <?= $successMsg ?>
        </div>
    <?php } ?>

    <form method="POST" enctype='multipart/form-data'>

        <div class="form-group my-3">
            <input type="date" name="date">
        </div>
        <button type="submit" class="btn btn-primary my-1">Passer à la phase de formulation des voeux</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/layoutadmin.php') ?>