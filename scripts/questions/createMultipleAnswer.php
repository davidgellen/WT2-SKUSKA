<?php

session_start();
require_once "../../database/QuestionService.php";
?>

<?php

    $question = $_POST["questionText"];
    $correct = $_POST["correct"];
    $wrong = $_POST["wrong"];
    $points = $_POST["points"];
    $type = "multi";
    $path = '../../testTemplatesJSON/test' . $_SESSION['test']['id'] . '.json';

    if($question!=null && $question!="" && $points!=null){
        $questionId = (new QuestionService)->createQuestion($_SESSION['test']['id'], $type, $path, $points);

        $data = ['type' => $type, 'question' => $question, 'correctAnswers' => $correct, 'wrongAnswers' => $wrong, 'points' => $points];
        $fp = fopen($path, 'r+');
        $contentObject = file_get_contents($path);
        $contentObject = json_encode($contentObject);
        $decoded = json_decode($contentObject, true);
        $content = json_decode($decoded, true);
        $allQuestions = $content['questions'];
        $allQuestions[$questionId] = $data;
        $content['questions'] = $allQuestions;
        fwrite($fp, json_encode($content));
        fclose($fp);
    }
    echo $_SESSION['test']['code'];
?>
