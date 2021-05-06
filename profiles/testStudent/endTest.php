<?php
    ini_set("display_errors", 1);
    require_once "../../database/StudentTestService.php";
    session_start();
    
    (new StudentTestService)->updateActivityState($_SESSION['recordId'], 0);

    session_destroy();
    header("Location: ../../index.php");
?>