<?php
    session_start();

    /*echo "addDrawing";
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
    <title>Otázka s kreslením</title>
</head>
<body>
    <h1>Vytvorenie kresliacej otázky</h1><br>
    <form action=<?="../../../scripts/questions/createDrawing.php?test=" . $_SESSION["test"]["code"]?> id="drawingAnswerForm" method="POST">
        <h3><label for="questionText">Znenie otázky</label></h3><br>
        <textarea id="questionText" name="questionText" cols="60" rows="5" form="drawingAnswerForm" required></textarea><br>

        <label for="points">Bodovanie</label><br>
        <input type="number" id="points" name="points" min="0" required><br><br>
        <input type="submit" value = "Vytvoriť" class="btnActivation"><br><br>
    </form>
    <button onclick="location.href = '../detail.php?test=<?php echo $_SESSION['test']['code']; ?>';" class="btnActivation">Späť</button>
</body>
</html>