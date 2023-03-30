<?php $title = "Médiathèque - Ajouter un jeu"; ?>

<?php ob_start(); ?>
<div class="w-50 mx-auto">
    <h1 class="my-3 text-center">Ajouter un jeu</h1>

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
            <label for="name">Nom</label>
            <input type="text" class="form-control" name="name" placeholder="Nom du jeu">
        </div>
        <div class="form-group my-3">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" placeholder="Description du jeu">
        </div>
        <div class="form-group my-3">
            <label for="category">Catégories</label>
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="category">
                <?php foreach($categories as $i => $category){ ?>
                <option <?php if($i==0) echo "selected" ?>><?= $category->name ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group my-3">
            <label for="nb_copies">Nombre d'exemplaires</label>
            <input type="int" class="form-control" name="nb_copies" placeholder="Nombre d'exemplaires">
        </div>
        
        <div class="form-group my-3">
            <label for="image">Image</label>
            <input class="form-control" type="file" name="image">
        </div>
        <button type="submit" class="btn btn-primary my-1">Ajouter le jeu</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/layoutadmin.php') ?>