<?php 
    class Deduction extends DB_object{


        protected static $db_name = "deduction";
        protected static $db_table_fields = array('name', 'amount');

        public $id;
        public $name;
        public $amount;
    
        public static $question_mark_embed = "?,?";
        protected static $database_data_type = 'si';



        public static function get_user_deduction_amount($user){

            $query = self::show_user_deduction($user);

            $total_allowance = 0;

            $result = $query->get_result();

            if($result->num_rows >= 1){
                while($row = $result->fetch_assoc()){
                    $total_allowance += $row['amount'];
                }
            }else{
                return 0;
            }

            return $total_allowance;
        }

        public static function delete_deduction_pivot_table($id){
            global $database;
            $delete_user_deduction_pivot_table_query = $database->prepare_query("DELETE FROM user_deduction WHERE id = ?");
            $escape_id = $database->escape_input($id);
            $delete_user_deduction_pivot_table_query->bind_param("i", $escape_id);
            if($delete_user_deduction_pivot_table_query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public static function add_deduction($user_id, $deduction_id){

            global $database;
            $add_deduction_query = $database->prepare_query(" INSERT INTO user_deduction (user_id, deduction_id)VALUES(?,?)");
            $escape_id = $database->escape_input($user_id);
            $escape_deduction_id = $database->escape_input($deduction_id);

            $add_deduction_query->bind_param("ss", $escape_id, $escape_deduction_id);
            $add_deduction_query->execute();
                

        }

        public static function get_user_not_selected_deduction($user){
            global $database;
            $escape_id = $user->id;
            $get_not_selected_deduction_query = $database->prepare_query(" SELECT * FROM deduction WHERE deduction.id NOT IN (SELECT user_deduction.deduction_id FROM user_deduction WHERE user_deduction.user_id = ?)");
            $get_not_selected_deduction_query->bind_param("i", $escape_id);
            $get_not_selected_deduction_query->execute();
            $result_get_not_selected_deduction = $get_not_selected_deduction_query->get_result();   

            $the_object_array = [];
            while($row = mysqli_fetch_assoc($result_get_not_selected_deduction)){
                $the_object_array[] = static::instantiation($row);
            }
            return $the_object_array;
        }

        public  static function show_user_deduction($user){
            global $database;
            $escape_id = $database->escape_input($user->id);
            $fetch_user_deduction = $database->prepare_query("SELECT user_deduction.id, deduction.id,deduction.amount, deduction.name FROM users INNER JOIN user_deduction ON users.id = user_deduction.user_id LEFT JOIN deduction ON user_deduction.deduction_id = deduction.id WHERE users.id = ?");
            $fetch_user_deduction->bind_param("i", $escape_id);
            if($fetch_user_deduction->execute()){
                return $fetch_user_deduction;
                
            }else{
                return false;
            }
        }
    }
