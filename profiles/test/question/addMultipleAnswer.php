<?php

    echo "add multiple answer<br>";

    echo "<pre>";
    var_dump($_POST);
    var_dump($_SESSION["test"]);
    echo "</pre>";

?>

<form action="../../../scripts/questions/createMultipleAnswer.php" id="multipleAnswerForm" method="POST">
    <label for="questionText">Znenie otázky</label><br>
    <textarea id="questionText" name="questionText" cols="60" rows="5" form="multipleAnswerForm"></textarea><br>
<div>
</div>
</form>
<br>

<button onclick="location.href = '../detail.php?test=<?php echo $_POST['testcode']; ?>';" >spat na detail</button><br>