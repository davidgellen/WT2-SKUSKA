<?php
    session_start();
    /*echo "add Short answer<br>";
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
    <title>Otázka s krátkou odpoveďou</title>
</head>
<body>
    <h1>Vytvorenie krátkej otázky</h1>
    <form action=<?="../../../scripts/questions/createShortAnswer.php?test=" . $_SESSION["test"]["code"]?> id="shortAnswerForm" method="POST">
        <h3><label for="questionText">Znenie otázky</label></h3><br>
        <textarea id="questionText" name="questionText" cols="60" rows="5" form="shortAnswerForm" required></textarea><br>

        <label for="answer">Správna odpoveď</label><br>
        <input type="text" id="answer" name="answer" required><br>

        <label for="points">Bodovanie</label><br>
        <input type="number" id="points" name="points" min="0" step="0.1" required><br><br>

        <input type="submit" id ="shortAnswerSubmit" value="Vytvoriť" class="btnActivation">

    </form>

    <br>

    <button onclick="location.href = '../detail.php?test=<?php echo $_SESSION['test']['code']; ?>';"class="btnActivation">Späť</button><br>
</body>
</html>