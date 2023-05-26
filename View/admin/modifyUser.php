<?php $title = "Ludocrèche - Modifier un compte"; ?>

<?php ob_start(); ?>
<div class="w-50 mx-auto">
    <h1 class="my-3 text-center">Modifier un compte</h1>

    <?php if (!empty($errorMsg)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $errorMsg ?>
        </div>
    <?php } else if (!empty($successMsg)) { ?>
        <div class="alert alert-success" role="success">
            <?= $successMsg ?>
        </div>
    <?php } ?>

    <form method="POST">
        <div class="form-group my-3">
            <label for="last_name">Nom de famille</label>
            <input type="text" class="form-control" name="last_name" placeholder="Entrez votre nom" value="<?= $user->last_name ?>">
        </div>
        <div class="form-group my-3">
            <label for="first_name">Prénom</label>
            <input type="text" class="form-control" name="first_name" placeholder="Entrez votre prénom" value="<?= $user->first_name ?>">
        </div>
        <div class="form-group my-3">
            <label for="email">Adresse e-mail</label>
            <input type="email" class="form-control" name="email" placeholder="Entrez votre e-mail" value="<?= $user->email ?>">
        </div>
        <div class="form-group my-3">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="password" placeholder="Entrez votre mot de passe" value="<?= $user->password ?>">
        </div>
        <div class="form-group my-3">
            <label for="category">Administrateur (Responsable)</label>
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="admin">
                <?php if($user->admin=="1"){
                    echo "<option selected>Oui</option>
                        <option>Non</option>";
                }else{
                    echo "<option selected>Non</option>
                        <option>Oui</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary my-1">Modifier le compte</button>
    </form>
</div>

<?php $content = ob_get_clean();?>
<?php
require(__DIR__ . '/layoutadmin.php');
?>