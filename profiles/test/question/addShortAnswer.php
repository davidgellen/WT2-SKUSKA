<?php

    session_start();
    echo "add Short answer<br>";

    echo "<pre>";
    var_dump($_POST);
    var_dump($_SESSION["test"]);
    echo "</pre>";
    

?>

<form action=<?="../../../scripts/questions/createShortAnswer.php?test=" . $_SESSION["test"]["code"]?> id="shortAnswerForm" method="POST">
    <label for="questionText">Znenie otázky</label><br>
    <textarea id="questionText" name="questionText" cols="60" rows="5" form="shortAnswerForm"></textarea><br>

    <label for="answer">Správna odpoveď</label><br>
    <input type="text" id="answer" name="answer"><br>

    <label for="points">Bodovanie</label><br>
    <input type="number" id="points" name="points" min="0" step="0.1"><br>

    <input type="submit" id ="shortAnswerSubmit" value = "Vytvor otázku">

</form>

<br>

<button onclick="location.href = '../detail.php?test=<?php echo $_SESSION['test']['code']; ?>';" >spat na detail</button><br>
