<?php

session_start();

echo "add Pairing";

echo "<pre>";
var_dump($_POST);
echo "</pre>";

?>

ked vytvoris otazku tak po ulozeni asi redirect na detail naspat neviem
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action=<?="../../../scripts/questions/createPairing.php?test=" . $_SESSION["test"]["code"]?> id="pairAnswerForm" method="POST">
        <label for="question">Review of W3Schools:</label>
        <textarea id="question" name="question" rows="4" cols="50"></textarea>
        <br><br>
        <div id="first" class="field_wrapper" style="float:left;">
            <div>
                <input type="text" name="field_name1[]" value=""/>
                <a href="javascript:void(0);" class="add_button" title="Add field"><img src="add-icon.png"/></a>
                <a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a>
            </div>
        </div>

        <div id="second" class="field_wrapper" style="float:left;">   
            <div>
                <input type="text" name="field_name2[]" value=""/>
                
            </div>
        </div>
        <label for="points">Body:</label><br>
        <input type="number" name="points" value=""/><br><br>
        <input type="submit" value="Submit">
    </form>

    <br>

    <button onclick="location.href = '../detail.php?test=<?php echo $_SESSION['test']['code']; ?>';" >spat na detail</button><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper1 = $('#first'); //Input field wrapper
        var wrapper2 = $('#second'); //Input field wrapper


        var fieldHTML1 = '<div><input type="text" name="field_name1[]" value=""/></div>'; //New input field html 
        var fieldHTML2 = '<div><input type="text" name="field_name2[]" value=""/></div>'; //New input field html 

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
        
        //Once remove button is clicked
        $(wrapper1).on('click', '.remove_button', function(e){
            e.preventDefault();
            //$(wrapper1).parent('div').remove(); //Remove field html
            //$(wrapper2).parent('div').remove(); //Remove field html
            $(wrapper1).children('div').last().remove();
            $(wrapper2).children('div').last().remove();
            x--; //Decrement field counter
        });
    });
</script>
</body>
</html>