<?php
session_start();

require_once "../database/Database.php";
require_once "../database/TestService.php";
require_once "../database/TeacherService.php";

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
    if(!$_SESSION['logged_as'] == "teacher"){
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
    <link rel="stylesheet" href="../styles/teacherProfile.css">
</head>
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
                        <a class="nav-link" href="../index.php">Administratíva <span class="sr-only">(current)</span></a>
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
                    <div class="menu_opt" onclick="menuOption(this)" id="opt1">Prehľad testov</div>
                    <div class="menu_opt" onclick="menuOption(this)" id="opt2">Vytvor test</div>
                </div>
            </div>
            <div class="col-sm-9 debug" id="content">
                <?php //TODO: Kontent - rozne veci, bude sa zobrazovat podla menu na ktore klikne ucitel ?>

                <div id="opt1_content" style="display: block;">

                    <h2>CHCEME TU BUTTONY NA AKTIVACIU A DEAKTIVACIU?</h2>
                    
                    <?php

                        $teacherId = (new TeacherService)->getTeacherFromSession()["id"];
                        $allTests = (new TestService)->getTestsByTeacherId($teacherId);

                        // TODO: cssko resp. ulozte si to uz ako uznate za vhodne kto to mate na starosti
                        // v a hrefe je to len provizorne ze aha funguje to 
                        // cez $test mas pristup k vsetmu z test_template
                        foreach ($allTests as $test){
                            echo "<p><a href = 'test/detail.php?test={$test['code']}'>{$test['name']} STATUS: {$test['status']}</a><p>";
                        }

                    ?>

                </div>

                <div id="opt2_content" style="display: none;">
                    <h2>Vytvor nový test</h2>

                    <div id = "queuedQuestions">

                        <form id = "createTestForm" method = "post" action = "../scripts/test/createTest.php">

                            <label for="testName">Meno testu:</label><br>
                            <input type="text" id="testName" name="testName"><br>
                            <label for="testDuration">Dlžka testu: </label><br>
                            <input type="number" id="testDuration" name="testDuration"><br>
                            <input type="submit" id ="createTestSubmit" value = "Vytvor Test">
                        
                        </form>

                    </div>

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
<?php include "../includes/footer.php";?>
</body>
</html>