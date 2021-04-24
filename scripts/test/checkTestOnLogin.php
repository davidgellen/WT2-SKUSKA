<?php

    require_once "../../database/TestService.php";
    
    $res = (new TestService)->getTestByCode($_POST["code"]);

    if ($res == null || $res == false){
        echo "0";
    } else {
        echo "1";
    }

?>