<?php

    session_start();
    require_once "../../database/QuestionService.php";
    echo "<pre>";
    var_dump($_SESSION['test']);
    echo "</pre>";

    echo "POST: ";
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    $question = $_POST["questionText"];
    //$answer = $_POST["answer"];
    $points = $_POST["points"];
    $equationJsonString = $_POST["equationJsonForm"];
    $type = "math";
    $path = '../../testTemplatesJSON/test' . $_SESSION['test']['id'] . '.json';

    $questionId = (new QuestionService)->createQuestion($_SESSION['test']['id'], $type, $path, $points);

    $data = ['type' => $type, 'question' => $question, 'equationJsonString' => $equationJsonString, 'points' => $points];
    $fp = fopen($path, 'r+');
    $contentObject = file_get_contents($path);
    $contentObject = json_encode($contentObject);
    $decoded = json_decode($contentObject, true);
    $content = json_decode($decoded, true);
    $allQuestions = $content['questions'];
    $allQuestions[$questionId] = $data;
    $content['questions'] = $allQuestions;

    $pointsRecieved = $content['pointsRecieved'];
    $pointsRecieved[$questionId] = "0";
    $content['pointsRecieved'] = $pointsRecieved;
    
    //var_dump($content);
    fwrite($fp, json_encode($content));
    fclose($fp);

    header('Location: ../../profiles/test/detail.php?test='.$_SESSION['test']['code']);


?>