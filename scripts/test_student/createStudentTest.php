<?php
//naplnenie JSON file-u odpovedami
require_once "../../database/StudentTestService.php";
session_start(); 

if(isset($_SESSION['logged_as'])){
    if(!$_SESSION['logged_as'] == "student"){
        session_destroy();
        header("Location: ../index.php");
    }
}

$result = "";
if(isset($_POST)){
    $testId = $_POST['testId'];
    $aisId = $_POST['aisId'];
    $path = "../../testStudentsJSON/test".$testId."/".$aisId.".json";

    
    $fp = fopen($path, 'r+');
    $contentObject = file_get_contents($path);
    $contentObject = json_encode($contentObject);
    $decoded = json_decode($contentObject, true);
    $content = json_decode($decoded, true);
    $allAnswers = $content['answers'];

    foreach($_POST as $key => $value){
        if(strcmp($key, "testId")==0 || strcmp($key, 'aisId')==0) continue;
        $allAnswers[$key] = $value;
    }

    $content['answers'] = $allAnswers;
    var_dump($content);
    fwrite($fp, json_encode($content));
    fclose($fp);
    

    $result = $content;
}

echo $result;
?>