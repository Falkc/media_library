<?php $title = "Médiathèque - Historique"; ?>
<?php ob_start(); ?>

<?php if (isset($errorMsg)) {
    echo "<h2>" . $errorMsg . "</h2>";
} else { ?>
    <br>
    <form method="POST">
        <div class="row">
            <div class="col">
                <div class="form-group my-3">
                    <label for="descrption">Dates</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="date">
                        <?php if (!isset($_POST['date'])) { ?>
                            <option selected><?php echo $dates[0]->format('Y-m-d H:i:s'); ?></option>
                            <?php foreach ($dates as $i => $date_str) {
                                if ($i != 0) { ?>
                                    <option><?php echo $date_str->format('Y-m-d H:i:s'); ?></option>
                            <?php }
                            }
                        } else { ?>
                            <option selected><?php echo $date_string->format('Y-m-d H:i:s'); ?></option>
                            <?php foreach ($dates as $date_str) {
                                if ($date_str->format('Y-m-d H:i:s') != $date_string->format('Y-m-d H:i:s')) { ?>
                                    <option><?php echo $date_str->format('Y-m-d H:i:s'); ?></option>
                        <?php }
                            }
                        } ?>

                    </select>
                </div>
            </div>
            <div class=" col-md-3 d-flex justify-content-center align-items-center col">
                <a href='<?= SITE ?>/admin/showHistory'> <button type="submit" class="btn btn-lg btn-primary">Changer la date</button></a>
            </div>
        </div>
    </form>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Jeux attribués</th>
            </tr>
        </thead>

        <?php

        foreach ($history as $hist) {
        ?>
            <tbody>
                <tr>
                    <th scope="row"><?php echo ucfirst($hist['lastname']) ?></th>
                    <td><?php echo ucfirst($hist['firstname']) ?></td>
                    <td><?php
                        $nbgame = count($hist['gamename']);
                        foreach ($hist['gamename'] as $i => $game_name) {
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
<?php }
$content = ob_get_clean(); ?>

<?php
require(__DIR__ . '/layoutadmin.php');
?>