// vlastne len vsetky button co poslu ajax a updatnu hodnotu live

$( document ).ready(function() {

    console.log("testACtivasion");

    $("#activateTest").click(function(e){
        e.preventDefault();
        let code = $("#codeValue").html();
        $.ajax({
            url: '../../scripts/test/activateTest.php',
            type: 'post',
            data: {code: code},
            success: function(){
                $("#statusValue").html("Aktívny ⬢");
            }
        });

    })

    $("#deactivateTest").click(function(e){
        e.preventDefault();
        let code = $("#codeValue").html();
        $.ajax({
            url: '../../scripts/test/deactivateTest.php',
            type: 'post',
            data: {code: code},
            success: function(){
                $("#statusValue").html("Neaktívny ⬡");
            }
        });

    })

});