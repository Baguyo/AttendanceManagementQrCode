<?php 
    class Position extends DB_object{


        protected static $db_name = 'position';
        protected static $db_table_fields = array('position_name', 'rate_per_hour', 'rate_per_overtime', 'department_id', 'time_start', 'time_end');

        public $id;
        public $position_name;
        public $rate_per_hour;
        public $rate_per_overtime;
        public $department_id;
        public $time_start;
        public $time_end;

        
    
        public static $question_mark_embed = "?,?,?,?,?,?";
        protected static $database_data_type = 'siiiss';


        public static function select_user_with_position($position_id){
            global $database;
            $select_user_with_position_query = $database->prepare_query("SELECT id FROM users WHERE users.position_id = ?");
            $select_user_with_position_query->bind_param('i', $position_id);
            $select_user_with_position_query->execute();
            $result_select_user_with_position_query = $select_user_with_position_query->get_result();

            if($result_select_user_with_position_query->num_rows >= 1){

                $all_user = [];
                while( $row =  $result_select_user_with_position_query->fetch_assoc()){
                    $all_user[] = $row['id'];
                }
                return $all_user;

            }else{
                return [];
            }
        }

        public static function find_all_joint_table(){
            global $database;
            $fetch_position_query = $database->prepare_query("SELECT position.id, position.position_name, position.rate_per_hour, position.rate_per_overtime, position.time_start, position.time_end, department.name FROM position INNER JOIN department ON position.department_id = department.id");
            $fetch_position_query->execute();
                return $fetch_position_query;
        }

    }
