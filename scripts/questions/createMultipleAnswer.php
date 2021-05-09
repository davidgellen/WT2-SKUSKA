<?php

session_start();
require_once "../../database/QuestionService.php";
var_dump($_SESSION['test']);
?>

<button onclick="location.href = '../../profiles/test/question/addShortAnswer.php?test=<?php echo $_SESSION['test']['code'];?>';" >Späť</button>
