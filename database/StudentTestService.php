<?php

require_once "Database.php";

session_start();

class StudentTestService {
    private $conn;

    public function addNewRecord($test_id, $student_id, $points, $active, $start_time){
        try{
            $this->conn = (new Database())->getConnection();
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->conn->prepare("INSERT INTO test_record (template_id, student_id, points, active, start_time) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$test_id, $student_id, $points, $active, date("Y-m-d H:i:s", $start_time)]);
            $id = $this->conn->lastInsertId();
        } catch (PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        $this->conn = null;
        return $id;
    }

    public function getRecord($test_id, $student_id){
        try{
            $this->conn = (new Database())->getConnection();
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->conn->prepare("SELECT * FROM test_record WHERE template_id=? AND student_id=?");
            $stmt->execute([$test_id, $student_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        $this->conn = null;
        return $result;
    }

    public function updateActivityState($recordId, $activityState){
        try{
            $this->conn = (new Database())->getConnection();
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->conn->prepare("UPDATE test_record SET active=? WHERE id=?");
            $stmt->execute([$activityState, $recordId]);
        } catch (PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        $this->conn = null;
    }
}

?>