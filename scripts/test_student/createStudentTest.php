<?php

require_once "../../database/StudentTestService.php";
session_start(); 

$result = "";
if(isset($_POST)){

    // (new StudentTestService)->

    echo json_encode($_POST);
}

echo $result;
?>