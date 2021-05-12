<?php
session_start();

require_once "../database/Database.php";
require_once "../database/TestService.php";
require_once "../database/StudentTestService.php";


ini_set("display_errors", 1);

try {
    $conn = (new Database())->getConnection();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if(isset($_POST['logout'])){
    (new StudentTestService)->updateActivityState($_SESSION['recordId'], 0);
    session_destroy();
    header("Location: ../index.php");
}

if(isset($_SESSION['logged_as'])){
    if(!$_SESSION['logged_as'] == "student"){
        session_destroy();
        header("Location: ../index.php");
    }
}


$testId = (new TestService)->getTestByCode($_SESSION["test_code"])["id"];
//to id sa pouziva v js scripte, ak chces zmenit kvoli css alebo daco bud
// napis Davidovi alebo tam len daj display none

$path = '../testTemplatesJSON/test' . $testId . '.json';
//$fp = fopen($path, 'r+');
$testFile = json_decode(file_get_contents($path));
$questions = $testFile->questions;

$testDuration = (new TestService)->getTestByCode($_SESSION['test_code'])['duration'];
//zaciatok odratavania casu

$stmt = $conn->prepare("SELECT id FROM student WHERE ais_id=?");
$stmt->execute([$_SESSION['ais_id']]);
$studentId = $stmt->fetchColumn();

if(!isset($_SESSION['start_time'])){
    $testStudentRecord = (new StudentTestService)->getRecord($testId, $studentId);
    if(count($testStudentRecord)==0){                               //ak sa na tento test este takyto student neprihlasil
        $_SESSION['start_time'] = time();
        $_SESSION['recordId'] = (new StudentTestService)->addNewRecord($testId, $studentId, 0, 1, $_SESSION['start_time']);
        $testStudentRecord = (new StudentTestService)->getRecord($testId, $studentId);

        //ID otazok z test templatu
        $qIds = array();
        foreach($questions as $qKey => $qValue){
            $qIds[$qKey] = array();
        }
        //vytvorenie JSON file-u studenta pre dany test
        if (!file_exists('../testStudentsJSON/test'.$testId)) {
            mkdir('../../testStudentsJSON/test'.$testId, 0777, true);
        }
        $fp = fopen("../testStudentsJSON/test".$testId . "/" . $_SESSION['ais_id'] . ".json", 'w');
        chmod("../testStudentsJSON/test" .$testId . "/" . $_SESSION['ais_id'] . ".json", 0777);
        fwrite($fp, json_encode(['test_id' => $testId, 'ais_id' => $_SESSION['ais_id'], 'answers' => $qIds]));
        fclose($fp);
    } else{                                                         //ak sa na tento test uz takyto student prihlasil pred tym
        $_SESSION['recordId'] = $testStudentRecord[0]['id'];
        (new StudentTestService)->updateActivityState($_SESSION['recordId'], 1); 
        $_SESSION['start_time'] = strtotime($testStudentRecord[0]['start_time']);
    }
    $_SESSION['target_time'] = $_SESSION['start_time'] + $testDuration*60;
}

//premenne pre parovaciu cast
$pairQuestionId=0;
$pairArr=[];
$questID=[];

//ak uz cas vyprsal, student sa uz na test nemoze prihlasit
if ($_SESSION['start_time'] + $testDuration*60 < time()){
    header("Location: testStudent/endTest.php");
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
    crossorigin="anonymous"></script>
    <?php include "../includes/header.php" ?>
    <link rel="stylesheet" href="../styles/styleBody.css">
    <link rel="stylesheet" href="../styles/studentProfile.css">
</head>
<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 center-content" id="betterWidth">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="../index.php"><?php include "../includes/name_page.php" ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Test <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <form action="studentProfil.php" method="post" class="form-inline my-2 my-lg-0">
                    <input type='submit' name='logout' value='Odhlásiť sa' class="btn1">
                </form>
            </div>
        </nav>
    </header>
    <!-- <a href="../index.php"><div class="btn btn-info">Hlavná stránka</div></a><br>  //TODO: Nefunkcne ak je v teste student - treba dokoncit, popr vymazat a nechat tlacitko Odhlasit sa-->
    <section id="exam"> <!-- TODO: export pdf/csv -->
        <div style="float: right;">
            <p>Prihlásený: <span id="name"><?=$_SESSION['name']?> </span><span id="surname"><?=$_SESSION['surname']?> </span><br>
            ID: <span id="aisId"><?=$_SESSION['ais_id']?></span></p>
        </div>

        <div style="text-align: center; margin-bottom: 5em;">
            Zostávajúci čas na dokončenie: <div id="countdown"><h3><?= strval(date("G", $_SESSION['target_time']-time())) . ':' . strval(date("i", $_SESSION['target_time']-time())) .":". strval(date("s", $_SESSION['target_time']-time())) ?></h3> </div>
        </div>


        <?php
            echo '<h2 hidden>Test id: <span id = "testIdHead">'.$testId.'</span></h2>';
            $tmp = 1;
            foreach ($questions as $key => $question){
                echo "<div class='testContent'>";
                echo "<div class='questionHead'>";
                echo "<div class='questionOrder'>" .$tmp."</div>";
                $tmp++;
                echo "<div style='padding: 0.5em 1.5em;'>";
                //echo "questionID: " . $key . "<br>";
                echo "<i>Typ otázky: " . $question->type . "</i><br>";
                echo "<span class = 'font-weight-bold'>Zadanie: </span>" . $question->question . "<br>";
                echo "</div></div>";
                // tuna sa dava ako sa zobrazi otazka a jak ju bude vyplnat student
                // ak je kodu vela dajte do ineho suboru a potom len include("cesta k suboru")
                // lebo sa v tom ani jurko nevyzna
                echo "<div class='questionBody'>";
                switch ($question->type){
                    case "short":
                        echo "Odpoveď: <br>";
                        echo "<input type='text' class='questionShort' id='". $key . "'><br>";
                        // Zuzka
                        break;
                    case "multi":
                        echo "Vyber všetky správne odpovede: <br>";
                        $correct = array();
                        $wrong = array();
                        if($question->correctAnswers != null)    $correct = $question->correctAnswers;
                        if($question->wrongAnswers != null)    $wrong = $question->wrongAnswers;
                        $allAnswers = array_merge($correct, $wrong);
                        shuffle($allAnswers); ?>
                        <div class='multiAnswer' id=<?=$key?>> <?php
                        foreach($allAnswers as $a){ 
                            echo "<input class=" . $key . " type='checkbox' value=".$a.">
                            <label>".$a."</label> <br>";
                        } ?>
                        </div> <?php
                        // Zuzka
                        break;
                    case "pair":
                        // Peter
                        ?>
                        <?php echo "<p>Zotrieď:</p>"?>
                            <div class="row">
                                <ul style="float: left;">
                                    <?php foreach($question->list1 as $item){
                                        echo "<li>$item</li>";
                                        }
                                    ?>

                                </ul>
                                <ul id="<?php echo $pairQuestionId;array_push($pairArr,$pairQuestionId);array_push($questID,$key); ?>" class="sortable" style="float: left; cursor: pointer;">
                                    <?php

                                    $reorder=$question->list2;
                                    shuffle($reorder);

                                    foreach($reorder as $item){
                                            echo "<li>$item</li>";
                                        }
                                    ?>
                                </ul>
                            </div>

                        <?php
                    	$pairQuestionId=$pairQuestionId+1;
                        break;
                    case "draw":
                        ?>
                            <button class = "drawRedirectBtn btnActivation" data-qid = <?php echo "\"".$key."\""; ?> data-filename = <?php echo ''.$testId.'_'.$_SESSION['ais_id'].'_'.$key.'.jpg';?>>Nakresliť</button>
                            <button class = "photoRedirectBtn btnActivation" data-qid = <?php echo "\"".$key."\""; ?> data-filename = <?php echo ''.$testId.'_'.$_SESSION['ais_id'].'_'.$key.'.jpg';?>>Odfotiť</button>
                            <div><p>Odpoveď:</p></div>
                            <div class="drawingOutput" data-qid = "<?php echo $key; ?>" data-filename = <?php echo $testId.'_'.$_SESSION['ais_id'].'_'.$key.'.jpg';?>></div> <!-- Ak by nieco neslo, menil som len uvodzovky kvoli html chybam-->
                        <?php
                        break;
                    case "math":
                        // echo "<pre>";
                        // var_dump($question->equationJsonString);
                        // echo "</pre>";
                        ?>
                            <?php //tu sa nacita rovnica ktoru zadal ucitel ?>
                            <div class="renderedEq" data-qid = <?php echo "\"".$key."\""; ?>></div>
                            <button class = "mathRedirectBtn btnActivation" data-qid = <?php echo "\"".$key."\""; ?>>Vytvoriť rovnicu</button>
                            <div><p>Odpoveď:</p></div>
                            <div class="renderedEqInput" data-qid = <?php echo "\"".$key."\""; ?>></div>
                        <?php
                        break;
                    default:
                        break;
                }
                echo "</div>";
                echo "</div>";
            }
        ?>
        <input type="button" id="endTest" name="endTest" value="Odovzdať" class="btn1 finishTest">
    </section>
</div>
<?php include "../includes/footer.php";?>
<script>
    $(document).ready(function(){
        window.onload = function()
        {
            window.localStorage.clear();
        }

        //odratavanie casu
        var timer2 = <?= strval(date("G", $_SESSION['target_time']-time())) ?> + ":" + <?= strval(date("i", $_SESSION['target_time']-time())) ?> + ":" + <?= strval(date("s", $_SESSION['target_time']-time())) ?> ;
        var interval = setInterval(function() {
        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var hours = parseInt(timer[0], 10);
        var minutes = parseInt(timer[1], 10);
        var seconds = parseInt(timer[2], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        hours = (minutes < 0) ? --hours : hours;
        if (minutes < 0) clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        minutes = (minutes < 0) ? 59 : minutes;
        minutes = (minutes < 10) ? '0' + minutes : minutes;
        if(minutes < 4 && hours == 0) $('#countdown').css('color', 'red');
        if ((seconds <= 0) && (minutes <= 0) && (hours <= 0)) {
            clearInterval(interval);
            $('#endTest').click();
        }
        $('#countdown').html("<h3>"+hours + ':' + minutes + ':' + seconds+"</h3>");
        timer2 =hours + ':' + minutes + ':' + seconds;
        }, 1000);


        $('.renderedEq').each(function(index) {
            fetch('../testTemplatesJSON/test'+ $('#testIdHead').html() +'.json')
                .then(response => response.json())
                .then(json => {
                    try{
                        let jsonObj = $.parseJSON(json["questions"][$(this).data("qid")]["equationJsonString"]);
                        //console.log(equationJson);
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

        $('.mathRedirectBtn').click(function(e){ // otvori novy window pre input math vyrazu
            window.open("testStudent/insertMath.php?qid="+$(this).data("qid"), '_blank').focus();
        })

        window.addEventListener('storage', () => { // zobere input a vlozi ho do prislusnej odpovede
            let mathQid = localStorage.getItem("mathqid");
            let jsonToRender = $.parseJSON(localStorage.getItem("answerJson")); // localstorage len stringy bere
            let allInput = $(".renderedEqInput");
            allInput.each(function(index){
                if ($(this).data("qid") ==  parseInt(mathQid)){
                    let equation = eqEd.Equation.constructFromJsonObj(jsonToRender);
                    $(this).empty();
                    $(this).append(equation.domObj.value);
                    equation.updateAll();
                }
            })
            
            //$("#result").html(localStorage.getItem("index"));
        });
                //drawings
                $('.drawRedirectBtn').click(function(e){
            window.open("testStudent/drawingEditor.php?qid="+$(this).data("qid")+"&filename="+$(this).data("filename"), '_blank').focus();
        })
        $('.photoRedirectBtn').click(function(e){
            window.open("testStudent/qrcode.php?qid="+$(this).data("qid")+"&filename="+$(this).data("filename"), '_blank').focus();
        })

        window.addEventListener('storage', () => {
            let drawingQid = localStorage.getItem("drawingqid");
            let drawingName = "../drawings/"+localStorage.getItem("drawingName");
            let drawingOutput = $(".drawingOutput");
            drawingOutput.each(function(index){
                if ($(this).data("qid") ==  parseInt(drawingQid)){
                    let image = document.createElement("img");
                    image.src = drawingName;
                    image.alt = "Nakresleny obrazok";
                    image.width = "200";
                    image.height = "200";
                    $(this).empty();
                    $(this).append(image);
                    window.localStorage.clear();
                }
            })
            
            //$("#result").html(localStorage.getItem("index"));
        });

        //Parovanie
        $( function() {
            $( ".sortable" ).sortable({
                update: function(e, ui) {
                    // gets the new and old index then removes the temporary attribute
                    var obj = <?php echo json_encode($pairArr); ?>;
                    var obj2 = <?php echo json_encode($questID); ?>;
                    answersToSend=[];
                    var i=0;
                    while(obj[i]!=null){
                        var tmp=[];
                        var unlist=document.getElementById(obj[i]);
                        var j=0;
                        while(unlist.getElementsByTagName('li')[j]!=null){
                            //console.log(unlist.getElementsByTagName('li')[j].innerHTML);
                            tmp.push(unlist.getElementsByTagName('li')[j].innerHTML);
                            j++;
                        }
                        //var answerObj = {id:obj[i], answers:tmp};
                        answersToSend.push({id:obj2[i], answers:tmp});
                        i++;
                        
                    }
                }
            });
            $( ".sortable" ).disableSelection();
  		});
    })
    
        

    
</script>
<script src="testStudent/submitTest.js"></script>
<?php include "../includes/mathQuestion/studentProfilMathPaths.php";?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>