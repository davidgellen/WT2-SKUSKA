//odoslanie odpovedi studenta

$('#endTest').click( function(e) {
    console.log("odovzdalo sa");
    console.log($("#countdown").text());

    //sem treba doplnit odpovede na jednotlive otazky
    var testData = {
        test_id: $("#testIdHead").text(),
        ais_id: $("#ais_id").text(),
    };

    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: '../scripts/test_student/createStudentTest.php',
        data: testData,
        dataType: "json",
        encode: true,
        success: function(data){
            console.log(data);
            window.location.href = "testStudent/endTest.php";
        }
    });

})