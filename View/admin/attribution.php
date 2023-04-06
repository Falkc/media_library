<?php $title = "Médiathèque - Attribution"; ?>
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
                <th scope="col">Jeux attribués</th>
            </tr>
        </thead>

        <?php
        foreach ($informations as $information) {
        ?>
            <tbody>
                <tr>
                    <th scope="row"><?php echo ucfirst($information->lastname) ?></th>
                    <td><?php echo ucfirst($information->firstname) ?></td>
                    <td><?php echo ucfirst($information->game_name) ?></td>
                </tr>
            <?php } ?>
            </tbody>
    </table>
    <?php //echo $cpt . ', ' . ucfirst($information->lastname) . ', ' . ucfirst($information->firstname) . ', ' . ucfirst($information->game_name); 
    ?>

<?php }
$content = ob_get_clean(); ?>

<?php
require(__DIR__ . '/layoutadmin.php');
?>