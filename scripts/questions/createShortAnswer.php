<?php

session_start();
require_once "../../database/QuestionService.php";
var_dump($_SESSION['test']);
?>

<button onclick="location.href = '../../profiles/test/question/addShortAnswer.php?test=<?php echo $_SESSION['test']['code'];?>';" >Späť</button>

<?php
    $question = $_POST["questionText"];
    $answer = $_POST["answer"];
    $points = $_POST["points"];
    $type = "short";
    $path = '../../testTemplatesJSON/test' . $_SESSION['test']['id'] . '.json';

    $questionId = (new QuestionService)->createQuestion($_SESSION['test']['id'], $type, $path, $points);

    $data = ['type' => $type, 'question' => $question, 'correctAnswer' => $answer, 'points' => $points];
    $fp = fopen($path, 'r+');
    $contentObject = file_get_contents($path);
    $contentObject = json_encode($contentObject);
    $decoded = json_decode($contentObject, true);
    $content = json_decode($decoded, true);
    $allQuestions = $content['questions'];
    $allQuestions[$questionId] = $data;
    $content['questions'] = $allQuestions;
    var_dump($content);
    fwrite($fp, json_encode($content));
    fclose($fp);

    header('Location: ../../profiles/test/detail.php?test='.$_SESSION['test']['code']);

?>