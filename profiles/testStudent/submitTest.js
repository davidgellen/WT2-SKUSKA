//odoslanie odpovedi studenta

var mathAnswers = new Object();
window.addEventListener('storage', () => { 
    let mathQid = localStorage.getItem("mathqid");
    let jsonToRender = $.parseJSON(localStorage.getItem("answerJson"));
    mathAnswers[mathQid] = jsonToRender;
});

$('#endTest').click( function(e) {
    console.log("odovzdalo sa");
    console.log($("#countdown").text());

    var shortQuestions = $(".questionShort");
    console.log(shortQuestions.length);

    //sem treba doplnit odpovede na jednotlive otazky
    var testData = {
        testId: $("#testIdHead").text(),
        aisId: $("#aisId").text(),
    };

    let allAns = new Object();
    
    //prida do testData odpovede na otazky S KRATKOU ODPOVEDOU
    for(var i = 0; i<shortQuestions.length; i++){
        testData[shortQuestions[i]['id']] = shortQuestions[i]['value'];
    }

    for (let key in mathAnswers){
        console.log(key);
        testData[key] = mathAnswers[key];
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