// zobrazenie additional info pre logins studenta

$( document ).ready(function() {

     $("#exam_code").on('propertychange input',function(e){
        let currentValue = document.getElementById("exam_code").value;
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'scripts/test/checkTestOnLogin.php',
            data: {code: currentValue},
            success: function(data){
                if(data == "1"){
                    //activateForm($("#login_asStudent"));
                    document.getElementById("additional_login").style.display = "block";
                } else{
                    document.getElementById("additional_login").style.display = "none";
                }
            }
        });
     })

     function activateForm(form) {
        let loginStudent = document.getElementById("login_asStudent");
        let loginTeacher = document.getElementById("login_asTeacher");

        //if(form.id === "loginStudent"){
            loginStudent.style.display = "block";
            loginTeacher.style.display = "none";
        // }
        // else{
        //     loginStudent.style.display = "none";
        //     loginTeacher.style.display = "block";
        // }
    }
})