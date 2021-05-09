<?php

    session_start();
    echo "addDrawing";

    echo "<pre>";
    var_dump($_POST);
    var_dump($_SESSION["test"]);
    echo "</pre>";

?>

ked vytvoris otazku tak po ulozeni asi redirect na detail naspat neviem
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action=<?="../../../scripts/questions/createDrawing.php?test=" . $_SESSION["test"]["code"]?> id="drawingAnswerForm" method="POST">
        <label for="questionText">Znenie otázky</label><br>
        <textarea id="questionText" name="questionText" cols="60" rows="5" form="drawingAnswerForm"></textarea><br>

        <label for="points">Bodovanie</label><br>
        <input type="number" id="points" name="points" min="0"><br>

        <input type="submit" value = "Vytvor otázku">

    </form>

</body>

<button onclick="location.href = '../detail.php?test=<?php echo $_SESSION['test']['code']; ?>';" >spat na detail</button><br>