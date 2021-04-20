<?php

    require_once "Database.php";

    class TestService{

        private $conn;

        public function createTest($teacherId, $name, $duration, $code){
            try {
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("INSERT INTO test_template 
                (teacher_id, name, code, status, duration) VALUES (:id, :name, :code, 0, :duration)");
                $stmt->bindParam("id", $teacherId);
                $stmt->bindParam("name", $name);
                $stmt->bindParam("code", $code);
                $stmt->bindParam("duration", $duration);
                $stmt->execute();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            $this->conn = null;
        }

        public function getTestsByTeacherId($teacherId){
            try {
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("SELECT * FROM test_template WHERE teacher_id = :teacher_id");
                $stmt->bindParam("teacher_id", $teacherId);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetchAll();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $this->conn = null;
            return $result;
        }

        public function getTestByCode($testCode){
            try {
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("SELECT * FROM test_template WHERE code = :code");
                $stmt->bindParam("code", $testCode);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetch();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $this->conn = null;
            return $result;
        }

        public function activateTest($code){
            try {
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("UPDATE test_template SET status = 1 WHERE code = :code");
                $stmt->bindParam("code", $code);
                $stmt->execute();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $this->conn = null;
        }

        // ano ide to aj ifom ale copy paste a komentar je rychlejsie
        public function deactivateTest($code){
            try {
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("UPDATE test_template SET status = 0 WHERE code = :code");
                $stmt->bindParam("code", $code);
                $stmt->execute();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $this->conn = null;
        }

    }

?>