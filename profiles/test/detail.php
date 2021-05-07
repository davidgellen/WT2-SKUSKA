<?php
session_start();
include "../../includes/header.php" ;
require_once "../../database/TestService.php";
require_once "../../database/TeacherService.php";
require_once "../../database/QuestionService.php";

if(isset($_SESSION['logged_as'])){
    if(!$_SESSION['logged_as'] == "teacher"){
        session_destroy();
        header("Location: ../../index.php");
    }
}

$testInfo = (new TestService)->getTestByCode($_GET["test"]);
$teacherInfo = (new TeacherService)->getTeacherFromId($testInfo["teacher_id"]);
$_SESSION["test"] = $testInfo;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../../includes/header.php" ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="testActivation.js"></script>
    <script src="addRedirect.js"></script>
    <link rel="stylesheet" href="../../styles/styleBody.css">
    <link rel="stylesheet" href="../../styles/teacherProfile.css">
</head>
<body class="d-flex flex-column min-vh-100" style="padding: 3em 10em 0 10em;">
<div class="wrapper flex-grow-1 center-content" id="betterWidth">
    <button onclick="location.href = '../../profiles/teacherProfil.php';" class="btnDetail" style="float: right">Naspäť</button><br><br>

    <div class="row">
        <div class="col-sm-4" style="text-align: left;">
            <?php
            echo "<p>ID Testu: " . $_SESSION["test"]["id"] . "</p>";
            echo "<p>Vytvoril učiteľ: " . $teacherInfo['name'] . " " . $teacherInfo['surname'] . "</p>";
            ?>
        </div>
        <div class="col-sm-4" style="text-align: center;">
            <?php
            echo "Názov testu: " . $testInfo["name"] . " - Kód testu: <span id='codeValue'>" . $testInfo["code"] . "</span></p>";
            echo "<p>Dĺžka testu: " . $testInfo["duration"] . " minút</p>";
            ?>
        </div>
        <div class="col-sm-4" style="text-align: right;">
            <?php
            $tmp = ($testInfo["status"] == "1") ? "Aktívny ⬢" : "Neaktívny ⬡";
            echo "<p>Status: <span id = 'statusValue'>" . $tmp . "</span></p>";
            ?>
            <p>
                <button id="activateTest" class="btnActivation">Aktivovať</button>
                <button id="deactivateTest" class="btnActivation">Deaktivovať</button>
            </p>
        </div>
    </div>

    <hr class="divider">

    <div class="row">
        <div class="col-sm-6" style="text-align: center;">
            <h2>Otázky</h2>
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
                </select><br>
                <input type = "submit" value = "Pridať otázku" class="btnActivation">
            </form>

            <br>

            <h4>Zoznam otázok</h4>
            <div class="listQuestions">
                <?php
                $path = '../../testTemplatesJSON/test' . $_SESSION["test"]["id"] . '.json';
                $questions = json_decode(file_get_contents($path))->questions;
                foreach ($questions as $key => $question){
                    echo "<div class='question'>";
                    echo "<div class='questionWindows' style='float: left;'>ID : " . $key . "</div>";
                    echo "<div class='questionWindows' style='float: right;'>Max. bodov: " . $question->points . "</div>";
                    echo " Typ otázky: " . formatQuestionType($question->type) . "<br>";
                    echo "<br>";
                    echo "Otázka: " . $question->question . "<br>";
                    //echo "správna odpoveď: " . $question->correctAnswer . "<br>"; //TODO: Add answers to question
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <div class="col-sm-1">

        </div>
        <div class="col-sm-5">
            <h2>Zoznam študentov prihlásených na test</h2>
            <p>kliknutim na nich sa presmerujeme na stranku, kde je test ktory ziak vyplnil, teda ak ho odovzdal<p>
                <!-- TODO: Spravit vypis studentov-->
        </div>
    </div>


</div>
<?php
function formatQuestionType($type){
    switch($type){
        case "short":
            return "Krátka odpoveď";
        case "pair":
            return "Priraďovanie";
        case "math":
            return "Matematika";
        case "multi":
            return "Multi uz ani neviem co to mam robit";
        case "draw":
            return "Kreslenie";
        default:
            return "ak toto nastalo tak sa nieco pokaslalo";
    }
}
?>
</body>
</html>

