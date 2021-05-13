<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../../includes/header.php" ?>
    <link rel="stylesheet" href="../../styles/styleBody.css">
    <link rel="stylesheet" href="../../styles/resultStudent.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <title>Hodnotenie</title>
</head>
<body>

    <?php
        require_once "../../database/TestService.php";
        $val = "window.location='../test/detail.php?test={$_SESSION["test"]["code"]}';";
        echo '<button onClick='.$val.' value="click here" class="btn1" style="float: right;">Späť</button>';

        // tieto spany sa vyuzivaju v scripte,
        // mozes to preprobit na hocico len innerHTML tych span ideciek musi zostat nezmenene
        echo"<div id='toPDF'>";
        echo "<div style='float: left;'>AIS ID: <span id = 'aisId'>" . $_POST["ais_id"] . "</span><br>";
        echo "<p>Kód testu: <span id = 'codeValue'>" . $_SESSION["test"]["code"] . "</span></p><br><br>";
        echo "<p hidden>testId: <span id = 'testId'>{$_SESSION["test"]["id"]}</span></p></div>";

        echo "<div style='height: 5em;'></div>";

        $recordPath = "../../testStudentsJSON/test{$_SESSION["test"]["id"]}/{$_POST["ais_id"]}.json";
        $testRecordFile = json_decode(file_get_contents($recordPath));

        $templatePath = "../../testTemplatesJSON/test{$_SESSION["test"]["id"]}.json";
        $testTemplateFile = json_decode(file_get_contents($templatePath));

        $pointsRecieved = $testRecordFile->pointsRecieved;

        $tmp = 1;
        foreach ($testTemplateFile->questions as $key => $question){
            echo "<div class='answer'>";
            echo "ID: " . $tmp++;
            echo "<span hidden>qId: ".$key . " - ". $question->question . "({$question->type})</span><br>";
            switch ($question->type){
                case "short":
                    // Zuzka ?>
                    <div><p>Odpoveď: </p></div>
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
                        <div><p>Odpoveď:</p></div>
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
            <?php $currentPointsRecieved = @$pointsRecieved->$key; ?>
            <input type="number" id=<?php echo "points" . $key;?> name=<?php echo "points" . $key;?> min="0" step="0.1"
                value = <?php echo $currentPointsRecieved;?> data-qid = <?php echo $key;?> class = "pointsInput">
            <?php
            echo "</div>";
        }
        echo "<p>Spolu bodov: <span id = 'pointTotal'>" . round($pointsRecieved->total,2) ."</span></p><br>";
        echo "</div>";

    ?>

    <button id = "evaluateQuestionsButton" class="btn1">Hodnotiť</button>
    <button onclick="toPdf();">Export do PDF</button>

    <script>
    function toPdf() {
	var element = document.getElementById('toPDF');
    var opt = {
        margin:       1,
        filename:     '<?php echo "TestID-".$_SESSION["test"]["id"]."_"."StudentAisID-".$_POST["ais_id"];?>.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    var worker = html2pdf().set(opt).from(element).save();   
    }
    
    $( document ).ready(function() {
    $('.renderedEq').each(function(index) {
        fetch('../../testStudentsJSON/test'+ $('#testId').html() +'/'+ $('#aisId').html() +'.json')
            .then(response => response.json())
            .then(json => {
                try{
                    let string = json["answers"][$(this).data("qid")];
                    if (string.length == 0){
                        $(this).html("Nevyplnené");
                    } else {
                        let jsonString = JSON.stringify(string);
                        let jsonObj = $.parseJSON(jsonString);
                        var equation = eqEd.Equation.constructFromJsonObj(jsonObj);
                        $(this).empty();
                        $(this).append(equation.domObj.value);
                        equation.updateAll();
                    }
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
<script src="html2pdf.js-master/dist/html2pdf.bundle.min.js"></script></body>

</body>
</html>