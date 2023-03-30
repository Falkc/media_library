<?php $title = "Médiathèque - Mediathèque" ?>

<?php ob_start(); ?>
<?php if (isset($_SESSION['id'])) {
  echo "<h2>Bonjour " . $_SESSION['first_name'] . '</h2>';
} else {
  echo "<h2> Pas connecté </h2>";
}
?>

<div class="row">
  <?php foreach ($games as $i => $game) { ?>
    <div class="card m-3" style="width: 18rem;">
      <a class="text-decoration-none text-reset" href="<?= SITE ?>/game/<?= $game->slug ?>">
        <img src="<?= URL."Images/" . $game->image ?>" class=" card-img-top flex-shrink-0" alt="<?= $game->name ?>">
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
<div class="m-4">
  <ul class="pagination justify-content-center">
    <li class="page-item <?php if ($page == 1) echo "disabled" ?>">
      <a class="page-link" href="<?= SITE ?>/page/1">
        << </a>
    </li>
    <li class="page-item <?php if ($page == 1) echo "disabled" ?>">
      <a class="page-link" href="<?= SITE ?>/page/<?= $page - 1 ?>">&laquo;</a>
    </li>
    <?php
    if ($page <= 2) {
      $gap = 3 - $page;
    } else if ($page >= $nbPages - 1) {
      $gap = -2 + ($nbPages - $page);
    } else {
      $gap = 0;
    }
    if ($nbPages >= 5) {
      $start = $page - 2 + $gap;
      $stop = $page + 2 + $gap;
    } else {
      $start = 1;
      $stop = $nbPages;
    }
    for ($i = $start; $i <= $stop; $i++) {
    ?>
      <li class="page-item <?php if ($page == $i) echo "active" ?>">
        <a class="page-link" href="<?= SITE ?>/page/<?= $i ?>"><?= $i ?></a>
      </li>
    <?php
    }
    ?>
    </li>
    <li class="page-item <?php if ($page == $nbPages) echo "disabled" ?>">
      <a class="page-link" href="<?= SITE ?>/page/<?= $page + 1 ?>">&raquo;</a>
    </li>
    <li class="page-item <?php if ($page == $nbPages) echo "disabled" ?>">
      <a class="page-link" href="<?= SITE ?>/page/<?= $nbPages ?>">>></a>
    </li>
  </ul>
</div>

<?php $content = ob_get_clean();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
  require('admin/layoutadmin.php');
} else {
  require('layout.php');
} ?>