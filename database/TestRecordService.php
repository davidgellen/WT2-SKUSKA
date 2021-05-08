<?php

    require_once "Database.php";

    class TestRecordService{

        private $conn;

        public function getStudentsStarted($test_code){
            try {
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("SELECT student.name, student.surname, student.ais_id FROM test_record JOIN student ON test_record.student_id = student.id 
                JOIN test_template on test_record.template_id = test_template.id WHERE test_template.code = :test_code");
                $stmt->bindParam("test_code", $test_code);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetchAll();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $this->conn = null;
            return $result;
        }

    }

?>