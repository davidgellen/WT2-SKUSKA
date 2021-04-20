<?php

    require_once "Database.php";

    session_start();

    class TeacherService{

        private $conn;

        public function getTeacherFromSession(){
            try {
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("SELECT * FROM teacher WHERE teacher.name = :name AND teacher.surname = :surname");
                $stmt->bindParam("name", $_SESSION["name"]);
                $stmt->bindParam("surname", $_SESSION["surname"]);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetch();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $this->conn = null;
            return $result;
        }

        public function getTeacherFromId($id){
            try {
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("SELECT * FROM teacher WHERE teacher.id = :id");
                $stmt->bindParam("id", $id);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetch();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $this->conn = null;
            return $result;
        }

    }

?>