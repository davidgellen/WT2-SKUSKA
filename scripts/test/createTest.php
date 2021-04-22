<button onclick="location.href = '../../profiles/teacherProfil.php';" >Späť</button>

<?php

    require_once "../../database/TeacherService.php";
    require_once "../../database/TestService.php";

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

    header('Location: ../../profiles/test/detail.php?test='.$testCode);

?>


