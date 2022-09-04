<?php 
    class Allowance extends DB_object{


        protected static $db_name = "allowance";
        protected static $db_table_fields = array('name', 'amount');

        public $id;
        public $name;
        public $amount;
    
        public static $question_mark_embed = "?,?";
        protected static $database_data_type = 'si';


        public static function get_user_allowance_amount($user){


            
            $query = self::show_user_allowance($user);

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


        public static function delete_allowance_pivot_table($id){
            global $database;
            $delete_user_allowance_pivot_table_query = $database->prepare_query("DELETE FROM user_allowance WHERE id = ?");
            $escape_id = $database->escape_input($id);
            $delete_user_allowance_pivot_table_query->bind_param("i", $escape_id);
            if($delete_user_allowance_pivot_table_query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public static function add_allowance($user_id, $allowance_id){

            global $database;
            $add_allowance_query = $database->prepare_query(" INSERT INTO user_allowance (user_id, allowance_id)VALUES(?,?)");
            $escape_id = $database->escape_input($user_id);
            $escape_allowance_id = $database->escape_input($allowance_id);

            $add_allowance_query->bind_param("ss", $escape_id, $escape_allowance_id);
            $add_allowance_query->execute();
                

        }


        public static function get_user_not_selected_allowance($user){
            global $database;
            $escape_id = $user->id;
            $get_not_selected_allowance_query = $database->prepare_query(" SELECT * FROM allowance WHERE allowance.id NOT IN (SELECT user_allowance.allowance_id FROM user_allowance WHERE user_allowance.user_id = ?)");
            $get_not_selected_allowance_query->bind_param("i", $escape_id);
            $get_not_selected_allowance_query->execute();
            $result_get_not_selected_allowance = $get_not_selected_allowance_query->get_result();   

            $the_object_array = [];
            while($row = mysqli_fetch_assoc($result_get_not_selected_allowance)){
                $the_object_array[] = static::instantiation($row);
            }
            return $the_object_array;
        }

        
        public  static function show_user_allowance($user){
            global $database;
            $escape_id = $database->escape_input($user->id);
            $fetch_user_allowance = $database->prepare_query("SELECT user_allowance.id, allowance.id,allowance.amount, allowance.name FROM users INNER JOIN user_allowance ON users.id = user_allowance.user_id LEFT JOIN allowance ON user_allowance.allowance_id = allowance.id WHERE users.id = ?");
            $fetch_user_allowance->bind_param("i", $escape_id);
            if($fetch_user_allowance->execute()){
                return $fetch_user_allowance;
                
            }else{
                return false;
            }
        }

    }
