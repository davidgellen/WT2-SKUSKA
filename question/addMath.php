<?php

echo "addMath";
echo "<pre>";
var_dump($_POST);
echo "</pre>";

?>

ked vytvoris otazku tak po ulozeni asi redirect na detail naspat neviem

<br>

<button onclick="location.href = '../test/teacher/detail.php?test=<?php echo $_POST['testcode']; ?>';" >spat na detail</button><br>