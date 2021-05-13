$("#evaluateQuestionsButton").click(function(){
    let totalPoints = 0;
    let allValues = {};
    $(".pointsInput").each(function(index){
        totalPoints += parseFloat($(this).val());
        allValues[$(this).data("qid").toString()] = $(this).val();
    })

    allValues["total"] = totalPoints.toString();

    let ais_id = $('#aisId').html();
    let test_id = $('#testId').html();

    $("#pointTotal").html(allValues["total"]);

    $.ajax({
        type: 'POST',
        url: '../../scripts/test_student/updatePoints.php',
        data: {values: allValues, ais_id: ais_id, test_id: test_id},
        datatype: 'json',
        success: function(data){
            console.log(data);
        },
        error: function(data){
            console.log("ajax error");
        }
    })
})

