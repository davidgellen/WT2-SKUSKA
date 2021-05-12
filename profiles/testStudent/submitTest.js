//odoslanie odpovedi studenta

var mathAnswers = new Object(); // math jsony
window.addEventListener('storage', () => { 
    let mathQid = localStorage.getItem("mathqid");
    let jsonToRender = $.parseJSON(localStorage.getItem("answerJson"));
    mathAnswers[mathQid] = jsonToRender;
});

var drawingAnswers = new Object();
window.addEventListener('storage', () => { 
    let drawingQid = localStorage.getItem("drawingqid");
    let drawingName = localStorage.getItem("drawingName");
    drawingAnswers[drawingQid] = drawingName;
});

$('#endTest').click( function(e) {
    console.log("odovzdalo sa");
    console.log($("#countdown").text());

    //sem treba doplnit odpovede na jednotlive otazky
    var testData = {
        testId: $("#testIdHead").text(),
        aisId: $("#aisId").text(),

    };
    
    //odpovede na otazky s VIAC ODPOVEDAMI
    var multiAnswers = $(".multiAnswer");
    for(var i = 0; i<multiAnswers.length; i++){  
        var checked = []; 
        var qid = multiAnswers[i]['id'];
        var inputs = multiAnswers.children('.'+qid);
        for(var j = 0; j<inputs.length; j++){
            if(inputs[j]['checked']){
                checked.push(inputs[j]['value']);
            }
        }
        testData[qid] = checked;
    }
    
    //odpovede na otazky S KRATKOU ODPOVEDOU
    var shortQuestions = $(".questionShort");
    for(var i = 0; i<shortQuestions.length; i++){
        testData[shortQuestions[i]['id']] = shortQuestions[i]['value'];
    }

    for (let key in mathAnswers){
        if(mathAnswers[key] != null){
            testData[key] = mathAnswers[key];
        }
    }

    for (let j in drawingAnswers){
        if(drawingAnswers[j] != null){
            testData[j] = drawingAnswers[j];
        }
    }
    
    //odpovede z parovania
    if (typeof answersToSend !== 'undefined') {
        // the variable is defined
        answersToSend.forEach(function (arrayItem) {
            testData[arrayItem.id]=arrayItem.answers;
        });
    }


    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: '../scripts/test_student/createStudentTest.php',
        data: testData,
        dataType: "json",
        encode: true,
        complete: function(data){
            console.log(data);
            window.location.href = "testStudent/endTest.php";
        }
    });

})