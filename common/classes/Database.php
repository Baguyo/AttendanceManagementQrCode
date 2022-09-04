<?php 

    class Database{

        private $connection;

        public $servername = "localhost";
        public $user = "root";
        public $password = "";
        public $database_name = "ams_with_qrcode";


        public function __construct()
        {
            $this->connect_database();
        }

        public function connect_database(){
            $db = new mysqli($this->servername, $this->user, $this->password, $this->database_name);

            if($db->connect_error){
                die("DATABASE CONNECTION FAILED");
            }
            
            $this->connection = $db;
        }

        public function query($sql){
            $result =  $this->connection->query($sql);
            $this->confirm_query($result);
            return $result; 
        }

        public function get_connection(){
            return $this->connection;
        }


        private function confirm_query($sql){
            if(!$sql){
                die("QUERY FAILED");
            }
        }

        public function get_insert_id(){
            return mysqli_insert_id($this->connection);
        }

        public function escape_input($value){
            return $this->connection->real_escape_string($value);
        }


        public function prepare_query($sql){
            return $this->connection->prepare($sql);
        }
    } //END OF DATABASE CLASS

    $database = new Database();
?>