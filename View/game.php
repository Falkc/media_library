<?php $title = "Médiathèque - Jeu"; ?>

<?php ob_start(); ?>

<?php if (isset($errorMsg)) {
    echo "<h2>" . $errorMsg . "</h2>";
} else { ?>



    <div class="container my-5">
        <?php if (isset($_SESSION['wishError'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $_SESSION['wishError'] ?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-3">
                <img src="<?= URL . "Images/" . $game->image ?>" class=" card-img-top flex-shrink-0" alt="<?= "Images/" . $game->image ?>">
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
            <?php if (!isset($_SESSION['id'])) { ?>
                <div class="col-md-3 d-flex justify-content-center align-items-center">
                    <a href='<?= SITE ?>/login'> <button type="button" class="btn btn-lg btn-primary">Se connecter pour ajouter aux voeux</button></a>
                </div>
            <?php } else if ($_SESSION['admin'] == 1) { ?>
                <div class="col-md-3 justify-content-center align-items-center">
                    <div class="row m-3">
                        <a href='<?= SITE ?>/admin/game/modify/<?= $game->id ?>'>
                            <button type="button" class="btn btn-lg btn-primary">
                                Modifier le jeu
                            </button>
                        </a>
                    </div>
                    <div class="row m-3">
                        <a href='<?= SITE ?>/admin/game/delete/<?= $game->id ?>'>
                            <button type="button" class="btn btn-lg btn-danger" onclick="return confirm('Etes vous sûr de vouloir supprimer ce jeu ?')">
                                Supprimer le jeu
                            </button>
                        </a>
                    </div>
                </div>
                <?php } else if ($phase == 1) {
                if ($checkwish == 1) { ?>
                    <div class=" col-md-3 d-flex justify-content-center align-items-center">
                        <a href='<?= SITE ?>/deletewishesandredirect/<?= $game->slug ?>/0'> <button type="button" class="btn btn-lg btn-primary">Supprimer de mes voeux</button></a>
                    </div>
                <?php } else { ?>
                    <div class="col-md-3 d-flex justify-content-center align-items-center">
                        <a href='<?= SITE ?>/addwishes/<?= $game->slug ?>'> <button type="button" class="btn btn-lg btn-primary">Ajouter à mes voeux</button></a>
                    </div>
                <?php }
            } else {
                if ($checkwish == 1) { ?>
                    <div class=" col-md-3 d-flex justify-content-center align-items-center">
                        <a href='<?= SITE ?>/deleteFreeBorrowAndRedirect/<?= $game->slug ?>/0'> <button type="button" class="btn btn-lg btn-primary">Retirer la demande</button></a>
                    </div>
                <?php } else { ?>
                    <div class="col-md-3 d-flex justify-content-center align-items-center">
                        <a href='<?= SITE ?>/addWishFreeBorrow/<?= $game->slug ?>'> <button type="button" class="btn btn-lg btn-primary">Demander le jeu</button></a>
                    </div>
            <?php }
            } ?>

        </div>
    </div>

<?php } ?>

<?php $content = ob_get_clean();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    require('admin/layoutadmin.php');
} else {
    require('layout.php');
} ?>