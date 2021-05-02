<?php
session_start();

require_once "../database/Database.php";
require_once "../database/TestService.php";

try {
    $conn = (new Database())->getConnection();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if(isset($_POST['logout'])){
    session_destroy();
    header("Location: ../index.php");
}

if(isset($_SESSION['logged_as'])){
    if(!$_SESSION['logged_as'] == "student"){
        session_destroy();
        header("Location: ../index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
    crossorigin="anonymous"></script>
    <?php include "../includes/header.php" ?>
    <link rel="stylesheet" href="../styles/styleBody.css">
    <link rel="stylesheet" href="../styles/about.css">
</head>
<body>
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
                    <input type='submit' name='logout' value='Odhlásiť sa'>
                </form>
            </div>
        </nav>
    </header>
    <article>
        <h1>Tu si daj text jaky ces</h1>
        
        <a  href="../index.php"><div class="btn btn-info">Hlavná stránka</div></a><br>
        <?php
            
            $testId = (new TestService)->getTestByCode($_SESSION["test_code"])["id"];
            //to id sa pouziva v js scripte, ak chces zmenit kvoli css alebo daco bud
            // napis Davidovi alebo tam len daj display none
            echo '<h2>Test id: <span id = "testIdHead">'.$testId.'</span></h2>';
            $path = '../testTemplatesJSON/test' . $testId . '.json';
            //$fp = fopen($path, 'r+');
            $questions = json_decode(file_get_contents($path))->questions;
            foreach ($questions as $key => $question){
                echo "<p>";
                echo "questionID: " . $key . "<br>";
                echo "Typ: " . $question->type . "<br>";
                echo "<span class = 'font-weight-bold'>Zadanie: </span>" . $question->question . "<br>";
                echo "</p>";
                // tuna sa dava ako sa zobrazi otazka a jak ju bude vyplnat student
                // ak je kodu vela dajte do ineho suboru a potom len include("cesta k suboru")
                // lebo sa v tom ani jurko nevyzna
                switch ($question->type){
                    case "short":
                        echo "<p>switch short vetva</p><br>";
                        // Zuzka
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
                        echo "<p>switch draw vetva</p><br>";
                        // Pato
                        break;
                    case "math":
                        // echo "<pre>";
                        // var_dump($question->equationJsonString);
                        // echo "</pre>";
                        ?>
                            <?php //tu sa nacita rovnica ktoru zadal ucitel ?>
                            <div class="renderedEq" data-qid = <?php echo "\"".$key."\""; ?>></div>
                            <button class = "mathRedirectBtn" data-qid = <?php echo "\"".$key."\""; ?>>Vypln</button>
                            <div><p>Odpoved:</p></div>
                            <div class="renderedEqInput" data-qid = <?php echo "\"".$key."\""; ?>></div>
                        <?php
                        break;
                    default:
                        break;
                }
                echo "----------------------<br>";
            }

        ?>
    </article>
</div>
<?php include "../includes/footer.php";?>
<script>
    $(document).ready(function(){
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
    })

    
</script>
<?php include "../includes/mathQuestion/studentProfilMathPaths.php";?>
</body>
</html>