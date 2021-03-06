<button onclick="location.href = '../../profiles/teacherProfil.php';" >Späť</button>

<?php

    require_once "../../database/TeacherService.php";
    require_once "../../database/TestService.php";
    ini_set('display_errors', 1);
    session_start();

    echo "<br>" . $_POST["testName"] . "<br>";
    echo $_POST["testDuration"] . "<br>";

    $testCode = substr(md5(uniqid(rand(), true)), 0, 6);

    $teacherId = (new TeacherService)->getTeacherFromSession()["id"];

    echo "id: " . $teacherId . "<br>";
    
    echo "<pre>";
    var_dump($_SESSION);
    echo "</pre>";

    (new TestService)->createTest($teacherId, $_POST["testName"], $_POST["testDuration"], $testCode);

    //create test folder
    $testId = (new TestService)->getTestByCode($testCode)["id"];
    if (!file_exists('../../testStudentsJSON/test'.$testId)) {
        mkdir('../../testStudentsJSON/test'.$testId, 0777, true);
    }

    //create JSON file
    chmod("../../testTemplatesJSON", 0777);
    $fp = fopen("../../testTemplatesJSON/test" . $testId . ".json", 'w');
    chmod("../../testTemplatesJSON/test" . $testId . ".json", 0777);
    fwrite($fp, json_encode(["teacher_id" => $teacherId, "name" => $_POST['testName'], "code" => $testCode, "duration" => $_POST['testDuration'], 'questions' => array()]));
    fclose($fp);



    header('Location: ../../profiles/test/detail.php?test='.$testCode);

?>


