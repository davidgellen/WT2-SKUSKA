<?php
session_start();

require_once "../database/Database.php";

try {
    $conn = (new Database())->getConnection();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if(isset($_POST['logout'])){
    session_destroy();
    header("Location: ../index.php");
}

if(isset($_SESSION['logged_as'])){
    if($_SESSION['logged_as'] == "student"){
        session_destroy();
        header("Location: ../index.php");
    }
}

?>

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
            <a class="navbar-brand" href="../index.php">BohovskaOhromnaAplikacia</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Test <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <form action="studentProfil.php" method="post" class="form-inline my-2 my-lg-0">
                    <input type='submit' name='logout' value='Odhlásiť sa'>
                </form>
            </div>
        </nav>
    </header>
    <article>
        <h1>Tu si daj text jaky ces</h1>
        <a  href="../index.php"><div class="btn btn-info">Hlavná stránka</div></a>
    </article>
</div>
<?php include "../includes/footer.php";?>
</body>
</html>