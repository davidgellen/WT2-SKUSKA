// vlastne len vsetky button co poslu ajax a updatnu hodnotu live

$( document ).ready(function() {

    $("#activateTest").click(function(e){
        e.preventDefault();
        let code = $("#codeValue").html();
        $.ajax({ 
            url: '../../source/test/activateTest.php',
            type: 'post',
            data: {code: code},
        });
        $("#statusValue").html("1");
    })

    $("#deactivateTest").click(function(e){
        e.preventDefault();
        let code = $("#codeValue").html();
        $.ajax({ 
            url: '../../source/test/deactivateTest.php',
            type: 'post',
            data: {code: code},
        });
        $("#statusValue").html("0");
    })

});