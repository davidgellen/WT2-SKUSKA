<?php

    require_once "../../database/TestService.php";
    
    $res = (new TestService)->getTestByCode($_POST["code"]);

    if ($res["status"] == "1"){
        if ($res == null || $res == false){
            echo "0";
        } else {
            echo "1";
        }
    } else {
        echo 0;
    }

    

?>