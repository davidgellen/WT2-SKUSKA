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
        
        foreach ($testTemplateFile->questions as $key => $question){
            echo "qId: ".$key . " - ". $question->question . "({$question->type})<br>";
            switch ($question->type){
                case "short":
                    // Zuzka ?>
                    <div><p>Odpoved: </p></div>
                    <p><?=$testRecordFile->answers->$key?></p><br><?php
                    break;
                case "multi":
                    echo "<p>switch multi vetva</p><br>";
                    // Zuzka
                    break;
                case "pair":
                    echo "<p>switch pair vetva</p><br>";
                    // Peter
                    break;
                case "draw":
                    ?>
                        <div><p>Odpoveď:</p></div>
                        <div class="drawingOutput" data-qid = <?php echo "\"".$key."\""; ?>></div>
                    <?php
                    break;
                case "math":
                    // echo "<pre>";
                    // var_dump($question->equationJsonString);
                    // echo "</pre>";
                    ?>
                        <?php //tu sa nacita rovnica ktoru zadal ucitel ?>
                        <div><p>Odpoved:</p></div>
                        <div class="renderedEq" data-qid = <?php echo "\"".$key."\""; ?>></div>
                    <?php
                    break;
                default:
                    break;
            }
            echo "----------------------<br>";
        }

    ?>

    <script>

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
                    console.log(error); // ani tu byt nemusi len to robi bordel vsade
                }
            })
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
</body>
</html>