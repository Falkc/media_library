<?php $title = "Ludocrèche - Mes jeux"; ?>

<?php ob_start(); ?>

<?php if (isset($errorMsg)) {
    echo "<h2>" . $errorMsg . "</h2>";
} else {
    foreach ($games as $game) { ?>

        <div class="container my-5">
            <div class="row">
                <div class="col-md-3">
                    <img src="<?= URL . "Images/" . $game->image ?>" alt="Nom du jeu" class="img-fluid">
                </div>

                <div class="col-md-6">
                    <h1> <?= $game->name ?> </h1>
                    <p>
                        <a href="<?= SITE . "/category/" . $game->category->slug ?>">
                            <span class="badge bg-primary mb-2">
                                <?= $game->category->name ?>
                            </span>
                        </a>
                    </p>
                    <h5>Description du jeu :</h5>
                    <p> <?= $game->description ?> </p>
                </div>
            </div>
        </div>

<?php }
} ?>

<?php $content = ob_get_clean();

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    require('admin/layoutadmin.php');
} else {
    require('layout.php');
} ?>