<?php
    require_once "../../database/Database.php";
    try {
        $conn = (new Database())->getConnection();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

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

    $sql = "SELECT id FROM student WHERE ais_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$aisId]);
    $studentID = $stmt->fetch(PDO::FETCH_NUM);

    $sql = "UPDATE test_record SET points = ? WHERE student_id = ? AND template_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$content["pointsRecieved"]["total"], $studentID[0], $testId]);

    fwrite($fp, json_encode($content));
    fclose($fp);