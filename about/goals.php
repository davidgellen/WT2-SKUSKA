<!DOCTYPE html>
<html lang="sk">
<head>
    <?php include "../includes/header.php" ?>
    <link rel="stylesheet" href="../styles/styleBody.css">
    <link rel="stylesheet" href="../styles/about.css">
</head>
<body>
<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 center-content" id="betterWidth">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="../index.php"><?php include "../includes/name_page.php" ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../source/sources.php">Dokumentácia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="goals.php">Ciele</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <article>
        <table class="table table-striped table-bordered table-hover" style="background-color: #d4f7f8;">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Meno</th>
                <th scope="col">Úloha</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td>David Gellen</td>
                <td>Realizácia otázok s matematickým výrazom</td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td>Zadefinovanie testov, aktivácia a deaktivácia</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Patrik Ištók</td>
                <td>Realizácia otázok s kreslením</td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td>Export do csv</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Patrik Kupčulák</td>
                <td>Prihlasovanie sa do aplikácie</td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td>Finalizácia aplikácie, grafika, štruktúra</td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td>Peter Krajčí</td>
                <td>Realizácia párovacích otázok</td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td>Info pre učiteľa o zbiehaní testov</td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td>Export do pdf</td>
            </tr>
            <tr>
                <th scope="row">5</th>
                <td>Zuzana Medzihradská</td>
                <td>Otázky s viacerými odpoveďami</td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td>Otázky s krátkymi odpoveďami</td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td>Ukončenie testu</td>
            </tr>
            </tbody>
        </table>
    </article>
</div>
<?php include "../includes/footer.php";?>
</body>
</html>