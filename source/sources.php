<!--
pozadie- https://www.svgbackgrounds.com/#rainbow-vortex by

-->
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
                        <a class="nav-link" href="sources.php">Dokumentácia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about/goals.php">Ciele</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <article>
        <h2>Dokumentácia</h2>
        <ul>
            <li><strong>Štruktúra projektu</strong>
                <ul>
                    <li>about - informačná stránka o rozdelení úloh</li>
                    <li>database - databáza a pripojenie</li>
                    <li>drawings - súbor pre ukladanie obrázkov zo strany študenta</li>
                    <li>includes - časti opakujúceho sa kódu, ktoré sa importovali</li>
                    <li>profiles - učiteľská  stránka a spolu s otázkami ktoré môže učiteľ pridať do testu</li>
                    <li>profiles - študentská stránka a spolu s otázkami ktoré môže študent odpovedať na test</li>
                    <li>scripts - skripty</li>
                    <li>source - dokumentácia a zdroje</li>
                    <li>sources - obrázky použité na stránke</li>
                    <li>styles - štýly</li>
                    <li>testStudentsJSON - odpovede študentov</li>
                    <li>testTemplatesJSON - súbory pre otázky, ktoré vytvoril učiteľ</li>
                </ul>
            </li>
            <li><strong>Nefunkčné požiadavky: docker, prehľad ci niekto opustil tab</strong>
                <ul>
                    <li>Docker</li>
                    <li>Prehľad či niekto opustil tab</li>
                </ul>
            </li>
            <li><strong>Funkcionalita</strong>
                <ul>
                    <li>Učiteľ:
                        <ul>
                            <li>Registrácia</li>
                            <li>Prihlásenie do učiteľa</li>
                            <li>Prehľad aktívnych a neaktívnych testov</li>
                            <li>Aktivácia a deaktivácia testov</li>
                            <li>Pridávanie 5 druhov otázok/úloh</li>
                            <li>Hodnotenie/Zobrazenie hodnotenia vypracovaného testu študentov</li>
                            <li>Export konkrétneho testu do pdf</li>
                            <li>Export hodnotení študentov do csv</li>
                            <li>Prehľad zoznamu otázok</li>
                            <li>Vytvorenie testu</li>
                        </ul>
                    </li>
                    <li>Študent:
                        <ul>
                            <li>Vyplnenie testu - 5 druhov otázok</li>
                            <li>Odovzdať test</li>
                            <li>*Test sa skončí automaticky po danom časovom limite</li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        <h2>Zdroje</h2>
        <ul style="list-style: none;">
            <li><a href="https://i.pinimg.com/originals/b1/b7/de/b1b7de37299d6d589ba3d7e28652869b.png">Ikona</a></li>
            <li><a href="https://github.com/camdenreslink/equation-editor">Matematika</a></li>
            <li><a href="https://github.com/endroid/qr-code">QR Sken na obrázok</a></li>
            <li><a href="https://ekoopmans.github.io/html2pdf.js/">Export to pdf</a></li>
            <li><a href="https://jqueryui.com/sortable/">Párovanie</a></li>
            <li><a href="https://codepen.io/BananaCoding/pen/mdrGjpL">Kresba</a></li>
            <li><a href="https://getbootstrap.com/">Bootstrap</a></li>
            <li><a href="https://www.svgbackgrounds.com/#rainbow-vortex">Pozadie</a></li>
        </ul>
    </article>
</div>
<?php include "../includes/footer.php";?>
</body>
</html>