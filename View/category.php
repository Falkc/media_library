<?php $title = "Ludocrèche - " . ucfirst($category->name); ?>
<?php ob_start(); ?>

<?php if (isset($errorMsg)) {
    echo "<h2>" . $errorMsg . "</h2>";
} else {
    echo '<h2>' . ucfirst($category->name) . '</h2>'; ?>
    <div class="row">
        <?php foreach ($games as $i => $game) { ?>
            <div class="card m-3" style="width: 18rem;">
                <a class="text-decoration-none text-reset" href="<?= SITE ?>/game/<?= $game->slug ?>">
                    <img src="<?= URL."Images/" . $game->image  ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $game->name ?></h5>
                        <hr>
                        <span class="badge bg-primary mb-2">
                            <?= $game->category->name ?>      
                        </span>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>

<?php }
$content = ob_get_clean();

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    require('admin/layoutadmin.php');
} else {
    require('layout.php');
} ?>