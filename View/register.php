<?php $title = "Médiathèque - S'inscrire"; ?>

<?php ob_start(); ?>
<div class="w-50 mx-auto">
    <h1 class="my-3 text-center">S'inscrire</h1>

    <?php if (!empty($errorMsg)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $errorMsg ?>
        </div>
    <?php } ?>

    <form method="POST">
        <div class="form-group my-3">
            <label for="last_name">Nom de famille</label>
            <input type="text" class="form-control" name="last_name" placeholder="Entrez votre nom">
        </div>
        <div class="form-group my-3">
            <label for="first_name">Prénom</label>
            <input type="text" class="form-control" name="first_name" placeholder="Entrez votre prénom">
        </div>
        <div class="form-group my-3">
            <label for="email">Adresse e-mail</label>
            <input type="email" class="form-control" name="email" placeholder="Entrez votre e-mail">
        </div>
        <div class="form-group my-3">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="password" placeholder="Entrez votre mot de passe">
        </div>
        <div class="form-group my-3">
            <label for="password">Vérification du mot de passe</label>
            <input type="password" class="form-control" name="password_verification" placeholder="Ré-entrez votre mot de passe">
        </div>
        <button type="submit" class="btn btn-primary my-1">S'inscrire</button>
    </form>
</div>

<?php $content = ob_get_clean();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    require('admin/layoutadmin.php');
} else {
    require('layout.php');
} ?>