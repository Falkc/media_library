<?php $title = "Médiathèque - Voir les voeux"; ?>
<?php ob_start(); ?>

<?php if (isset($errorMsg)) {
    echo "<h2>" . $errorMsg . "</h2>";
} else { ?>

    <br>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Voeux formulés</th>
            </tr>
        </thead>

        <?php
        foreach ($informations as $information) {
        ?>
            <tbody>
                <tr>
                    <th scope="row"><?php echo ucfirst($information['lastname']) ?></th>
                    <td><?php echo ucfirst($information['firstname']) ?></td>
                    <td><?php
                        $nbgame = count($information['gamename']);
                        foreach ($information['gamename'] as $i => $game_name) {
                            echo ucfirst($game_name) ?>
                        <?php if ($i != $nbgame - 1) {
                                echo ',';
                            }
                        } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
    </table>

    <br>
    <div class=" col-md-3 d-flex justify-content-center align-items-center">
        <a href='<?= SITE ?>/admin/attribution'> <button type="button" class="btn btn-lg btn-primary">Lancer l'attribution</button></a>
    </div>

    <br>
    <?php if (isset($_SESSION['errorMsg2'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['errorMsg2'] ?>
        </div>
    <?php } ?>
    <form method="POST">
        <div class="row">
            <div class="col">
                <div class="form-group my-3">
                    <label for="descrption">Membres</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="member">
                        <option selected><?php echo ucfirst($allUsers[0]->last_name) . ' ' . ucfirst($allUsers[0]->first_name); ?></option>
                        <?php foreach ($allUsers as $i => $user) {
                            if ($i != 0) { ?>
                                <option><?php echo ucfirst($user->last_name) . ' ' . ucfirst($user->first_name); ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>
            </div>

            <div class="col">
                <div class="form-group my-3">
                    <label for="descrption">Jeux</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="game">
                        <option selected><?php echo $allGames[0]->name; ?></option>
                        <?php foreach ($allGames as $i => $game) {
                            if ($i != 0) { ?>
                                <option><?php echo $game->name; ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>

            </div>
            <br>
            <div class=" col-md-3 d-flex justify-content-center align-items-center col">
                <a href='<?= SITE ?>/admin/showwishes'> <button type="submit" class="btn btn-lg btn-primary">Ajouter une contrainte</button></a>
            </div>
        </div>
    </form>

    <?php if (isset($_SESSION['constraintTable']) && isset($_SESSION['nbConstraint'])) {
        foreach ($_SESSION['constraintTable'] as $i => $constraint) {
            //if ($i <= $_SESSION['nbConstraint']) { 
    ?>
            <div class="row">
                <div class="col">
                    <?php echo '<p>' . $constraint['member'] . ' ' . $constraint['game'] . '</p>'; ?>
                </div>
                <div class="col">
                    <a href='<?= SITE ?>/admin/showwishes/<?php echo $i + 1 ?>'> <button type="boutton" class="btn btn-lg btn-primary btn-sm">Supprimer la contrainte</button></a>
                </div>
            </div>
    <?php //}
        }
    } ?>
    <br>







<?php }
?>
<?php $content = ob_get_clean(); ?>

<?php //require(__DIR__ . '/../layout.php')
require(__DIR__ . '/layoutadmin.php');
?>