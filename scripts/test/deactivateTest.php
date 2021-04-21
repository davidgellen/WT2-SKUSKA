<?php   
   
    require_once "../../database/TestService.php";

    (new TestService)->deactivateTest($_POST["code"]);

?>