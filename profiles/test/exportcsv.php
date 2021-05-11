<?php
    session_start();
    require_once "../../database/Database.php";
    try {
        $conn = (new Database())->getConnection();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $sql = "SELECT student.ais_id, student.name, student.surname, test_record.points FROM test_record INNER JOIN student ON test_record.student_id=student.id WHERE template_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION["test"]["id"]]);
    $vysledky = $stmt->fetchAll(PDO::FETCH_NUM);
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=hodnotenia.csv');
    function outputCSV($data) {
        $output = fopen("php://output", "wb");
        fputcsv($output, array('Ais ID', 'Krstné meno', 'Priezvisko', 'Celkové body'));
        foreach ($data as $row)
            fputcsv($output, $row);
        fclose($output);
      }

      outputCSV($vysledky);
?>