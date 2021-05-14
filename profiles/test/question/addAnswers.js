$(document).ready(function () {

    $("#addCorrect").click(function (e) {
        $("#correctAnswers").append("<br><textarea class='correct' cols='60' rows='2'></textarea><br>");
    });
    
    $("#addWrong").click(function (e) {
        $("#wrongAnswers").append("<br><textarea class='wrong' cols='60' rows='2'></textarea><br>");
    });

    
    $("#submitForm").click(function (e) {
        var correctData = Array();
        var wrongData = Array();
        var points = $("#points").val();
        var questionText = $("#questionText").val();

        if($(".correct").length >0){

        for(var i = 0; i<$(".correct").length; i++){
            correctData.push($(".correct")[i].value);
        }
        for(var i = 0; i<$(".wrong").length; i++){
            wrongData.push($(".wrong")[i].value);
        }

        if(correctData==null) correctData = {};
        if(wrongData==null) wrongData = {};

        var data = {
            questionText: questionText,
            correct: correctData,
            wrong: wrongData,
            points: points,
        }

        $.ajax({
            type: 'POST',
            url: '../../../scripts/questions/createMultipleAnswer.php',
            data: data,
            datatype: 'json',
            encode: true,
            success: function(data){
                console.log(data);
                var redirect = "../detail.php?test=" + data;
                window.location.href = redirect;
            }
        })
    }
    });

    
    })