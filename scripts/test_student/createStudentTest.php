<?php
//naplnenie JSON file-u odpovedami
require_once "../../database/StudentTestService.php";
session_start(); 

if(isset($_SESSION['logged_as'])){
    if(!$_SESSION['logged_as'] == "student"){
        session_destroy();
        header("Location: ../index.php");
    }
}

$result = "";
if(isset($_POST)){

    // (new StudentTestService)->

    echo json_encode($_POST);
}

echo $result;
?>