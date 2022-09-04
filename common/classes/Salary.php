<?php 
    class Salary extends DB_object{


        protected static $db_name = "salary";
        protected static $db_table_fields = array('user_id', 'date_from', 'date_to', 'position', 'total_salary');

        public $id;
        public $user_id;
        public $date_from;
        public $date_to;
        public $position;
        public $total_salary;
    
        public static $question_mark_embed = "?,?,?,?,?";
        protected static $database_data_type = 'isssi';


        public static function find_by_user_id(User $user){
            global $database;

            $user_id = $database->escape_input($user->id);
            $find_by_user_id_query = $database->prepare_query("SELECT * FROM salary WHERE user_id = ?");

            $find_by_user_id_query->bind_param('i', $user_id);

            $find_by_user_id_query->execute();

            $result = $find_by_user_id_query->get_result();

            if($result->num_rows >= 1){
                $object_result = [];

                while($row = $result->fetch_assoc()){
                    $object_result[] = self::instantiation($row);
                }
                return $object_result;

            }else{
                return [];
            }



        }
        
    }
