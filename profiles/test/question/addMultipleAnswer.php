<?php
    session_start();
    /*echo "add multiple answer<br>";

    echo "<pre>";
    var_dump($_POST);
    var_dump($_SESSION["test"]);
    echo "</pre>";*/
    if(isset($_SESSION['logged_as'])){
        if(!$_SESSION['logged_as'] == "teacher"){
            session_destroy();
            header("Location: ../../../index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../../../includes/header.php" ?>
    <link rel="stylesheet" href="../../../styles/styleBody.css">
    <link rel="stylesheet" href="../../../styles/addTestQuestion.css">
    <title>Otázka s viacerými odpoveďami</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
    crossorigin="anonymous"></script>
</head>
<body>
<h1>Vytvorenie otázky s viacero odpoveďami</h1>
<h3><label for="questionText">Znenie otázky</label></h3><br>
<textarea id="questionText" name="questionText" cols="60" rows="5" required></textarea><br>

<p>Správne odpovede:</p>
<button id="addCorrect" class="btnActivation">+</button>
<div id="correctAnswers"></div>

<p>Nesprávne odpovede:</p>
<button id="addWrong" class="btnActivation">+</button>
<div id="wrongAnswers"></div>

<label for="points">Bodovanie</label><br>
<input type="number" id="points" name="points" min="0" step="0.1" required><br>

<br>
<input type="button" id="submitForm" value="Vytvoriť" class="btnActivation">
<br><br>

<button onclick="location.href = '../detail.php?test=<?php echo $_POST['testcode']; ?>';" class="btnActivation">Späť</button><br>

<script src="addAnswers.js"></script>
</body>
</html>