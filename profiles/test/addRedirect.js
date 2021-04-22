// vlastne len vsetky button co poslu ajax a updatnu hodnotu live

$( document ).ready(function() {

    console.log("addRedirect");

    $("#questionType").change(function(e){
        let redirect = "question/add" + $("#questionType").val() + ".php";
        $('#addQuestionForm').attr('action', redirect);
        
    })    

});