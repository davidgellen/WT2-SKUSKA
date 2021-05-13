<?php
    session_start();
    /*echo "add Pairing";
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";*/
    if(isset($_SESSION['logged_as'])){
        if(!$_SESSION['logged_as'] == "teacher"){
            session_destroy();
            header("Location: ../../../index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../../../includes/header.php" ?>
    <link rel="stylesheet" href="../../../styles/styleBody.css">
    <link rel="stylesheet" href="../../../styles/addTestQuestion.css">
    <title>Otázka s párovácými možnosťami</title>
</head>
<body>
    <h1>Vytvorenie párovacej otázky</h1><br>
    <form action=<?="../../../scripts/questions/createPairing.php?test=" . $_SESSION["test"]["code"]?> id="pairAnswerForm" method="POST">
        <h3><label for="question">Znenie otázky</label></h3><br>
        <textarea id="question" name="question" rows="4" cols="50" required></textarea>
        <br><br>
        <a href="javascript:void(0);"class="add_button" title="Add field"><strong class="btnActivation">+</strong></a>
        <a href="javascript:void(0);" class="remove_button"><strong class="btnActivation">-</strong></a><br><br>
        <div style="margin: auto; max-width: 30em;">
            <div id="first" class="field_wrapper" style="float: left;">
                <div>
                    <input type="text" name="field_name1[]" value="" required/>
                </div>
            </div>

            <div id="second" class="field_wrapper">
                <div>
                    <input type="text" name="field_name2[]" value="" required/>
                </div>
            </div>
        </div>
        <label for="points">Body:</label><br>
        <input type="number" name="points" value="" required><br><br>
        <input type="submit" value="Vytvoriť" class="btnActivation">
    </form>

    <br>

    <button onclick="location.href = '../detail.php?test=<?php echo $_SESSION['test']['code']; ?>';" class="btnActivation">Späť</button><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var removeButton = $('.remove_button'); //Remove button selector
        var wrapper1 = $('#first'); //Input field wrapper
        var wrapper2 = $('#second'); //Input field wrapper

        var fieldHTML1 = '<div><input type="text" name="field_name1[]" value="" required></div>'; //New input field html
        var fieldHTML2 = '<div><input type="text" name="field_name2[]" value="" required></div>'; //New input field html

        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper1).append(fieldHTML1); //Add field html
                $(wrapper2).append(fieldHTML2); //Add field html
            }
        });

        $(removeButton).click(function(){
            //Check maximum number of input fields
            if(x>1){
                console.log("somtu");
                //$(wrapper1).parent('div').remove(); //Remove field html
                //$(wrapper2).parent('div').remove(); //Remove field html
                $(wrapper1).children('div').last().remove();
                $(wrapper2).children('div').last().remove();
                x--; //Decrement field counter
            }
        });
        
    });
</script>
</body>
</html>