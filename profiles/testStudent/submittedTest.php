<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
    crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>

    <?php
        session_start();
        require_once "../../database/TestService.php";
        $val = "window.location='../test/detail.php?test={$_SESSION["test"]["code"]}';";
        echo '<button onClick='.$val.' value="click here">SPAT</button>';

        // tieto spany sa vyuzivaju v scripte,
        // mozes to preprobit na hocico len innerHTML tych span ideciek musi zostat nezmenene
        echo "<br>user: <span id = 'aisId'>" . $_POST["ais_id"] . "</span><br>";
        echo "test: " . $_SESSION["test"]["code"] . "<br><br>";
        echo "<p>testId: <span id = 'testId'>{$_SESSION["test"]["id"]}</span></p><br>";

        $recordPath = "../../testStudentsJSON/test{$_SESSION["test"]["id"]}/{$_POST["ais_id"]}.json";
        $testRecordFile = json_decode(file_get_contents($recordPath));

        $templatePath = "../../testTemplatesJSON/test{$_SESSION["test"]["id"]}.json";
        $testTemplateFile = json_decode(file_get_contents($templatePath));

        $pointsRecieved = $testRecordFile->pointsRecieved;
        
        foreach ($testTemplateFile->questions as $key => $question){
            echo "qId: ".$key . " - ". $question->question . "({$question->type})<br>";
            switch ($question->type){
                case "short":
                    // Zuzka ?>
                    <div><p>Odpoved: </p></div>
                    <p><?=$testRecordFile->answers->$key?></p><br><?php
                    break;
                case "multi": ?>
                    <div><p>Vybrané odpovede: </p></div><?php
                    for($i = 0; $i<count($testRecordFile->answers->$key); $i++){
                        echo "<p>".$testRecordFile->answers->$key[$i]."</p>";
                    };
                    // Zuzka
                    break;
                case "pair":
                    // Peter
                    ?>
                    <br>
                            <div class="row">
                                <ul style="float: left;">
                                    <?php foreach($question->list1 as $item){
                                        echo "<li>$item</li>";
                                        }
                                    ?>

                                </ul>
                                <ul style="float: left;">
                                    <?php

                                    $testRecordFile->answers->$key;

                                    foreach($testRecordFile->answers->$key as $item){
                                            echo "<li>$item</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            
                        <?php
                    break;
                case "draw":
                    ?>
                        <div><p>Odpoveď:</p></div>
                        <div class="drawingOutput" data-qid = <?php echo "\"".$key."\""; ?>></div>
                    <?php
                    break;
                case "math":
                    ?>
                        <?php //tu sa nacita rovnica ktoru zadal ucitel ?>
                        <div><p>Odpoved:</p></div>
                        <div class="renderedEq" data-qid = <?php echo "\"".$key."\""; ?>></div>
                    <?php
                    break;
                default:
                    break;
            }?>
            <br>
            <?php
                //echo "hodnotenie: " . $pointsRecieved->$key . "<br>";
            ?>
            <label for=<?php echo "points" . $key;?>>Hodnotenie:</label><br>
            <?php $currentPointsRecieved = $pointsRecieved->$key; ?>
            <input type="number" id=<?php echo "points" . $key;?> name=<?php echo "points" . $key;?> min="0" step="0.1"
                value = <?php echo $currentPointsRecieved;?> data-qid = <?php echo $key;?> class = "pointsInput">
            <?php
            echo "<br>----------------------<br>";
        }
        echo "<p>spolu: <span id = 'pointTotal'>" . $pointsRecieved->total ."</span></p><br>";

    ?>

    <button id = "evaluateQuestionsButton">Hodnot</button>

    <script>

    $( document ).ready(function() {
    $('.renderedEq').each(function(index) {
        fetch('../../testStudentsJSON/test'+ $('#testId').html() +'/'+ $('#aisId').html() +'.json')
            .then(response => response.json())
            .then(json => {
                try{
                    let jsonString = JSON.stringify(json["answers"][$(this).data("qid")]);
                    let jsonObj = $.parseJSON(jsonString);
                    var equation = eqEd.Equation.constructFromJsonObj(jsonObj);
                    $(this).empty();
                    $(this).append(equation.domObj.value);
                    equation.updateAll();
                }
                catch(error){ 
                    console.log(error); 
                }
                })
            });
    });

    $('.drawingOutput').each(function(index) {
    fetch('../../testStudentsJSON/test'+ $('#testId').html() +'/'+ $('#aisId').html() +'.json')
        .then(response => response.json())
        .then(json => {
            try{
                let imagename = json["answers"][$(this).data("qid")];
                let image = document.createElement("img");
                image.src = "../../drawings/"+imagename;
                image.alt = "Nakresleny obrazok";
                image.width = "400";
                image.height = "400";
                $(this).empty();
                $(this).append(image);
            }
            catch(error){ 
            }
        })
    });
    
    </script>


<?php include "../../includes/mathQuestion/insertMathPaths.php";?>
<script src = "../../scripts/test_student/evaluateTest.js"></script>
</body>
</html>