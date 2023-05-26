<?php $title = "Ludocrèche - Voir les membres"; ?>
<?php ob_start(); ?>

    <br>
    <br>
    <style>
        .spoiler {
            background-color: #31303D;
            color: #31303D;
            padding:7px;
            cursor: pointer;
            border-radius: 10px;
            display: inline-block;
        }

        .spoiler-content {
            display: none;
            padding:7px;
            cursor: pointer;
        }

        .spoiler.active {
            display: none;
        }

        .spoiler.active + .spoiler-content {
            display: inline-block;
        }
    </style>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">E-mail</th>
                <th scope="col">Mot de passe</th>
                <th scope="col">Admin</th>
                <th scope="col">Création</th>
                <th scope="col">Modifier</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($adminUsers as $adminUser) {
        ?> 
            <tr>
                <th scope="row"><?= $adminUser->last_name ?></th>
                <td><?= $adminUser->first_name?></td>
                <td><?= $adminUser->email ?></td>
                <td>
                    <div class="spoiler" onclick="this.classList.toggle('active')"><?=$adminUser->password ?></div>
                    <div class="spoiler-content" onclick="this.previousElementSibling.classList.toggle('active')">
                        <?=$adminUser->password ?>
                    </div>
                </td>
                <td style="color:red;">Oui</td>
                <td><?=$adminUser->registration_date->format('d/m/Y')?></td>
                <td><a href='<?= SITE ?>/admin/user/modify/<?=$adminUser->id?>'> <button type="button" class="btn btn-dark">Modifier</button></a></td>
            </tr>
        <?php }
        foreach ($noAdminUsers as $noAdminUser) {
        ?> 
                <tr>
                    <th scope="row"><?= $noAdminUser->last_name ?></th>
                    <td><?= $noAdminUser->first_name ?></td>
                    <td><?= $noAdminUser->email ?></td>
                    <td>
                        <div class="spoiler" onclick="this.classList.toggle('active')"><?=$noAdminUser->password ?></div>
                        <div class="spoiler-content" onclick="this.previousElementSibling.classList.toggle('active')">
                            <?=$noAdminUser->password ?>
                        </div>
                    </td>
                    <td>Non</td>
                    <td><?=$noAdminUser->registration_date->format('d/m/Y')?></td>
                    <td><a href='<?= SITE ?>/admin/user/modify/<?=$noAdminUser->id?>'> <button type="button" class="btn btn-dark">Modifier</button></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
<?php $content = ob_get_clean(); ?>

<?php
require(__DIR__ . '/layoutadmin.php');
?>