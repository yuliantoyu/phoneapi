<?php

    class Phone{

       
        private $conn;

       
        private $db_table = "phonenumber";

        
        public $id;
        public $numberphone;
       

       
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getPhonenumber(){
            $sqlQuery = "SELECT id, numberphone FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function create(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        numberphone = :numberphone
                      ";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->numberphone=htmlspecialchars(strip_tags($this->numberphone));
           
        
            // bind data
            $stmt->bindParam(":numberphone", $this->numberphone);
           
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSinglePhone(){
            $sqlQuery = "SELECT
                        id,
                        numberphone
                      FROM
                        	phonenumber
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            
           
           
           
          
			$this->numberphone = $dataRow['numberphone'];
			
				
        }        

        // UPDATE
        public function updatePhone(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                    numberphone = :numberphone
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // bind data
            $stmt->bindParam(":numberphone", $this->numberphone);
            
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deletePhone(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>

