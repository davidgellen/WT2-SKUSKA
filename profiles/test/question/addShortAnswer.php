<?php

    echo "add Short answer<br>";

    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

?>

ked vytvoris otazku tak po ulozeni asi redirect na detail naspat neviem

lmao

<br>

<button onclick="location.href = '../detail.php?test=<?php echo $_POST['testcode']; ?>';" >spat na detail</button><br>
