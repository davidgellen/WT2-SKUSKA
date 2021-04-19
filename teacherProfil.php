<?php
session_start();

require_once "database/Database.php";
try {
    $conn = (new Database())->getConnection();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if(isset($_POST['logout'])){
    session_destroy();
    header("Location: index.php");
}

if(isset($_SESSION['logged_as'])){
    if($_SESSION['logged_as'] == "teacher"){
        //Do something
    }
}else{
    session_destroy();
    header("Location: index.php");
}


?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <?php include "includes/header.php" ?>
    <link rel="stylesheet" href="styles/styleBody.css">
    <link rel="stylesheet" href="styles/teacherProfile.css">
</head>
<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 center-content" id="betterWidth">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">BohovskaOhromnaAplikacia</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Administratíva <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <form action="teacherProfil.php" method="post" class="form-inline my-2 my-lg-0">
                    <input type='submit' name='logout' value='Odhlásiť sa'>
                </form>
            </div>
        </nav>
    </header>
    <div class="container">
        <div class="row" style="height: 91.3vh;">
            <div class="col-sm-3 debug" id="profile">
                <div id="profile_info">
                    <?php
                    if(isset($_SESSION['name']) && isset($_SESSION['surname'])){
                        echo "Prihláseny:<br>" . $_SESSION['name'] . " " . $_SESSION['surname'];
                    }
                    ?>
                </div>
                <hr class="style-eight">
                <div id="profile_menu">
                    <?php //TODO: Menu s roznymi polozkami(zobrazenie testov, pridanie testov,...) - musi byt rovnaky pocet ako v kontextovom okne ?>
                    <div class="menu_opt" onclick="menuOption(this)" id="opt1">Možnosť 1</div>
                    <div class="menu_opt" onclick="menuOption(this)" id="opt2">Možnosť 2</div>
                </div>
            </div>
            <div class="col-sm-9 debug" id="content">
                <?php //TODO: Kontent - rozne veci, bude sa zobrazovat podla menu na ktore klikne ucitel ?>
                <div id="opt1_content" style="display: block;">
                    Kontent možnosti 1

                </div>
                <div id="opt2_content" style="display: none;">
                    Kontent možnosti 2

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function menuOption(option) {
        let options = 2; //Sumár všetkých možností
        for(let i = 1; i <= options; i++){
            if(option.id !== "opt"+(i)){
                document.getElementById("opt"+(i)+"_content").style.display = "none";
            }else{
                document.getElementById(option.id+"_content").style.display = "block";
            }
        }
    }
</script>
<?php include "includes/footer.php";?>
</body>
</html>