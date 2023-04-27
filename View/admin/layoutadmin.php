<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">
    <link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.css">
    <!-- <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css"> -->
</head>

<body>
    <?php if ($phase == 1) { ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= SITE ?>">Médiathèque</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE ?>/categories">Catégories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE ?>/admin/game/add/">Ajouter un jeu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE ?>/admin/showwishes">voir les voeux</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href=" http://www.association-galipette.org/site/">Association Galipette</a>
                        </li>
                    </ul>
                    <?php if (isset($_SESSION['id'])) { ?>
                        <a href="<?= SITE ?>/logout"><button class="btn btn-secondary my-2 my-sm-0">Se déconnecter</button></a>
                    <?php } else { ?>
                        <a href="<?= SITE ?>/register"><button class="btn btn-secondary my-2 my-sm-0 mx-3">Créer un compte</button></a>
                        <a href="<?= SITE ?>/login"><button class="btn btn-secondary my-2 my-sm-0">Se connecter</button></a>
                    <?php } ?>
                </div>
            </div>
        </nav>
    <?php } else if ($phase == 2) { ?>

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= SITE ?>">Médiathèque</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE ?>/categories">Catégories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE ?>/admin/game/add/">Ajouter un jeu</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= SITE ?>/admin/passToPhase1">Passer à la phase de voeux</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href=" http://www.association-galipette.org/site/">Association Galipette</a>
                        </li>
                    </ul>
                    <?php if (isset($_SESSION['id'])) { ?>
                        <a href="<?= SITE ?>/logout"><button class="btn btn-secondary my-2 my-sm-0">Se déconnecter</button></a>
                    <?php } else { ?>
                        <a href="<?= SITE ?>/register"><button class="btn btn-secondary my-2 my-sm-0 mx-3">Créer un compte</button></a>
                        <a href="<?= SITE ?>/login"><button class="btn btn-secondary my-2 my-sm-0">Se connecter</button></a>
                    <?php } ?>
                </div>
            </div>
        </nav>


    <?php } ?>
    <div class="container">
        <?= $content ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>

</html>