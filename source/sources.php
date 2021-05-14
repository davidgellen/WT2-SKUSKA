<!--
pozadie- https://www.svgbackgrounds.com/#rainbow-vortex by

-->

<?php

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <?php include "../includes/header.php" ?>
    <link rel="stylesheet" href="../styles/styleBody.css">
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
                        <a class="nav-link" href="sources.php">Zdroje</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about/goals.php">Ciele</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <article>
        <ul style="list-style: none;">
        <li><a href="https://i.pinimg.com/originals/b1/b7/de/b1b7de37299d6d589ba3d7e28652869b.png">Ikona</a></li>
        <li><a href="https://github.com/camdenreslink/equation-editor">Matematika</a></li>
        <li><a href="https://github.com/endroid/qr-code">QR Sken na obrázok</a></li>
        <li><a href="https://ekoopmans.github.io/html2pdf.js/">Export to pdf</a></li>
        <li><a href="https://jqueryui.com/sortable/">Párovanie</a></li>
        <li><a href="https://codepen.io/BananaCoding/pen/mdrGjpL">Kresba</a></li>
        <li><a href="https://getbootstrap.com/">Bootstrap</a></li>
        </ul>
    </article>
</div>
<?php include "../includes/footer.php";?>
</body>
</html>