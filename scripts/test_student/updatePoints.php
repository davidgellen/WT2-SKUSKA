<?php
    
    $testId = $_POST['test_id'];
    $aisId = $_POST['ais_id'];
    $path = "../../testStudentsJSON/test".$testId."/".$aisId.".json";
    $fp = fopen($path, 'r+');
    $contentObject = file_get_contents($path);
    $contentObject = json_encode($contentObject);
    $decoded = json_decode($contentObject, true);
    $content = json_decode($decoded, true);

    foreach ($_POST["values"] as $key => $questionPoints){
        //echo $key . " - " . $questionPoints . "      ";
        $content["pointsRecieved"][strval($key)] = $questionPoints;
    }

    //$content["pointsRecieved"] = $newPointsRecieved;
    // echo "POST:";
    // var_dump($_POST["values"]);
    // echo "CONTENT:";
    // var_dump($content["pointsRecieved"]);

    fwrite($fp, json_encode($content));
    fclose($fp);