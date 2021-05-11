<?php
    session_start();
    echo "add multiple answer<br>";

    echo "<pre>";
    var_dump($_POST);
    var_dump($_SESSION["test"]);
    echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
    crossorigin="anonymous"></script>
</head>
<body>
    
</body>
</html>
<label for="questionText">Znenie otázky</label><br>
<textarea id="questionText" name="questionText" cols="60" rows="5"></textarea><br>

<p>Správne odpovede:</p>
<button id="addCorrect">+</button>
<div id="correctAnswers">

</div>

<p>Nesprávne odpovede:</p>
<button id="addWrong">+</button>
<div id="wrongAnswers">
    
</div>

<label for="points">Bodovanie</label><br>
<input type="number" id="points" name="points" min="0" step="0.1"><br>

<br>
<input type="button" id="submitForm" value="Pridať">
<br><br>

<button onclick="location.href = '../detail.php?test=<?php echo $_POST['testcode']; ?>';" >spat na detail</button><br>

<script src="addAnswers.js"></script>
</body>
</html>