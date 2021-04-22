<?php

    require_once "Database.php";

    session_start();

    class QuestionService{

        private $conn;

        // pridavanie otazok vyberanie a tak
        // neviem jak sa budu este vkladat
        public function createQuestion ($test_id, $type, $path, $points){
            try{
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("INSERT INTO question 
                    (test_template_id, question, answer, points) VALUES (?, ?, ?, ?)");
                $stmt->execute([$test_id, $type, $path, $points]);
                $id = $this->conn->lastInsertId();
            } catch (PDOException $e){
                echo "Error: " . $e->getMessage();
            }

            $this->conn = null;
            return $id;
        }

        public function getQuestionsByTestId($test_id){
            try{
                $this->conn = (new Database())->getConnection();
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $this->conn->prepare("SELECT * FROM question WHERE test_template_id=?");
                $stmt->execute([$test_id]);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $this->conn = null;
            return $result;
        }
    }

?>