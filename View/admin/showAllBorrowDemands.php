<?php $title = "Ludocrèche - Demandes d'emprunts libres"; ?>

<?php ob_start(); ?>

<?php if (isset($errorMsg)) {
    echo "<h2>" . $errorMsg . "</h2>";
} else {
    foreach ($fbdAndUser as $fbdNUser) { ?>
        <h2> <?= $fbdNUser->last_name . ' ' . $fbdNUser->first_name ?> </h2>
        <?php foreach ($fbdNUser->fbd_array as $fbd) { ?>

            <div class="container my-5">
                <div class="row">
                    <div class="col-md-3">
                        <img src="<?= URL . "Images/" . $fbd->image ?>" alt="Nom du jeu" class="img-fluid">
                    </div>

                    <div class="col-md-6">
                        <h1> <?= $fbd->name ?> </h1>

                        <?php if ($fbd->demandState == 0) {
                            $state_string = "En attente";
                            $marker = 1;
                        } else if ($fbd->demandState == 1) {
                            $state_string = "Acceptée";
                            $marker = 0;
                        } else if ($fbd->demandState == -1) {
                            $state_string = "Refusée";
                            $marker = 0;
                        } ?>

                        <?php
                        $states = [];
                        $states[0] = "Refusée";
                        $states[1] = "Acceptée";



                        ?>

                        <h5>Description du jeu :</h5>
                        <p> <?= $fbd->description ?> </p>
                        <form method="POST" enctype='multipart/form-data'>

                            <div class="form-group my-3">
                                <label for="state">Etat de la demande:</label>
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="state">

                                    <option <?= "selected" ?>><?= $state_string ?></option>
                                    <?php foreach ($states as $i => $state) {
                                        if ($state != $state_string) {
                                            if ($requestMarker == 1 and $i == 2) {
                                            } else { ?>
                                                <option><?= $state ?></option>

                                    <?php }
                                        }
                                    } ?>
                                </select>

                                <input type="hidden" name="user_id" value="<?= $fbdNUser->user_id ?>">
                                <input type="hidden" name="game_id" value="<?= $fbd->id ?>">
                                <input type="hidden" name="previous_state" value="<?= $state_string ?>">
                                <button type="submit" class="btn btn-primary my-1">Changer le statut de la demande</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

<?php }
    }
} ?>

<?php $content = ob_get_clean();
require(__DIR__ . '/layoutadmin.php'); ?>