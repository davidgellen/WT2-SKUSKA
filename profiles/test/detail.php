<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styleBody.css">
    <link rel="stylesheet" href="../../styles/teacherProfile.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
    crossorigin="anonymous"></script>
    <script src="testActivation.js"></script>
    <script src="addRedirect.js"></script>
    <title>Document</title>
</head>
<body>

    <?php 
        session_start();    
        include "../../includes/header.php" ;
        require_once "../../database/TestService.php";
        require_once "../../database/TeacherService.php";
    ?>   

    <button onclick="location.href = '../../profiles/teacherProfil.php';" >Home</button><br>

    <?php  
        echo "file v /test/teacher/detail.php az budes robit ccs<br>";
        $testInfo = (new TestService)->getTestByCode($_GET["test"]);
        echo "meno: " . $testInfo["name"] . "<br>";
        echo "<p>kod: <span id ='codeValue'>" . $testInfo["code"] . "</span></p>";
        $teacherInfo = (new TeacherService)->getTeacherFromId($testInfo["teacher_id"]);
        echo "vytvoril: " . $teacherInfo["name"] . " " . $teacherInfo["surname"] . "<br>";
        echo "<p>status: <span id = 'statusValue'>" . $testInfo["status"] . "</span></p>";
        echo "dlzka: " . $testInfo["duration"] . "<br>";
    ?>

    <br><br>

    <div>
    
        <h4>Pridanie otázky</h4>

        <form id = "addQuestionForm" method = "post" action = "question/addMultipleAnswer.php">
            <input type="hidden" name="testcode" value=<?php echo $testInfo["code"]; ?>>
            <label for="questionType">Typ otázky:</label>
            <select name="questionType" id="questionType" form="addQuestionForm">
                <option value="MultipleAnswer">Viacero odpovedí</option>
                <option value="ShortAnswer">Krátka odpoveď</option>
                <option value="Pairing">Párovanie</option>
                <option value="Drawing">Kresba</option>
                <option value="Math">Matematika</option>
            </select>
            <input type = "submit" value = "Pridať">
        </form>
    
    </div>

    <br><br>

    <button id = "activateTest">Aktivovať</button>

    <button id = "deactivateTest">Deaktivovať</button>

    <h2>zoznam studentov, co ten test zacali robit</h2>
    <p>kliknutim na nich sa presmerujeme na stranku, kde je test ktory ziak vyplnil, teda ak ho odovzdal<p>
    
</body>
</html>

