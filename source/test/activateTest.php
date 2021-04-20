<?php

    require_once "../../database/TestService.php";

    (new TestService)->activateTest($_POST["code"]);

?>