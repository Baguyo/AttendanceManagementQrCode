<?php 
    class Appeal extends DB_object{
        protected static $db_name = "appeal";
        protected static $db_table_fields = array('user_id', 'date', 'reason', 'time_status', 'time', 'status');

        public $id;
        public $user_id;
        public $date;
        public $reason;
        public $time_status;
        public $time;
        public $status;

        public static $question_mark_embed = "?,?,?,?,?,?";
        protected static $database_data_type = 'isssss';

        public static $time_field_status = [
            'first time in' => 'first_time_in',
            'first time out' => 'first_time_out',
            'second time in' => 'second_time_in',
            'second time out' => 'second_time_out',
            'third time in' => 'third_time_in',
            'third time out' => 'third_time_out',
        ];


        public static function find_appeal_by_column($user_id, $date, $status){
            global $database;
            $user_id = $database->escape_input($user_id);
            $date = $database->escape_input($date);
            $status = $database->escape_input($status);

            $appeal_find_query = $database->prepare_query("SELECT id FROM appeal WHERE user_id = ? AND date = ? AND time_status = ?");
            $appeal_find_query->bind_param("iss", $user_id, $date, $status);
            $appeal_find_query->execute();
            $appeal_find_result = $appeal_find_query->get_result();

            if($appeal_find_result->num_rows >= 1){
                $row = $appeal_find_result->fetch_assoc();
                return $appeal = self::find_by_id($row['id']);
            }else{
                return false;
            }

        }


        public function create_appeal_and_attendance(){
            global $database;

            $escape_user_id = $database->escape_input($this->user_id);
            $escape_date = $database->escape_input($this->date);
            $escape_time_status = $database->escape_input($this->time_status);
            $escape_time = $database->escape_input($this->time);

            $create_appeal_query = $database->prepare_query("INSERT INTO attendance (user_id, date, $escape_time_status) VALUES (?,?,'00:00:10') ");
            $create_appeal_query->bind_param('is', $escape_user_id, $escape_date );
            if($create_appeal_query->execute()){
                return true;
            }else{
                return false;
            }

        }


        public function ajax_approve_appeal(){
            global $database;
            $ajax_approve_appeal = $database->prepare_query("UPDATE attendance SET " . $this->time_status . " = ? WHERE user_id = ? AND date = ? ");

            $escape_time = $database->escape_input($this->time);
            $escape_user_id = $database->escape_input($this->user_id);
            $escape_date = $database->escape_input($this->date);

            $ajax_approve_appeal->bind_param('sis', $escape_time, $escape_user_id, $escape_date);
            $ajax_approve_appeal->execute();

            if(mysqli_affected_rows( $database->get_connection() ) === 1){
                return true;
            }else{
                return false;
            }
        }

        public function ajax_denied_appeal(){
            global $database;

            $ajax_denied_appeal = $database->prepare_query("UPDATE attendance SET " . $this->time_status . " = '00:00:10' WHERE user_id = ? AND date = ? ");

            
            $escape_user_id = $database->escape_input($this->user_id);
            $escape_date = $database->escape_input($this->date);

            $ajax_denied_appeal->bind_param('is', $escape_user_id, $escape_date);
            $ajax_denied_appeal->execute();

            $this->status = "denied";
            if($this->update()){
                return true;
            }else{
                return false;
            }

        }

        public static function joint_table_find_all(){
            global $database;
            $fetch_all_appeal = $database->prepare_query("SELECT appeal.id, appeal.date, appeal.reason, appeal.time_status, appeal.time, appeal.status, users.first_name, users.last_name FROM appeal LEFT JOIN users ON appeal.user_id = users.id ORDER BY appeal.id DESC");
            $fetch_all_appeal->execute();
            return $fetch_all_appeal;

        }

        public function check_if_attendance_existed(){
            global $database;

            $escape_user_id = $database->escape_input($this->user_id);
            $escape_date = $database->escape_input($this->date);
            $escape_time_status = $database->escape_input($this->time_status);

            $check_if_attendance_existed_query = $database->prepare_query("SELECT * FROM attendance WHERE user_id = ? AND date = ? AND $escape_time_status != '00:00:00' ");
            $check_if_attendance_existed_query->bind_param("is", $escape_user_id, $escape_date);
            $check_if_attendance_existed_query->execute();

            $result_check_if_attendance_existed = $check_if_attendance_existed_query->get_result();

            if($result_check_if_attendance_existed->num_rows >= 1){
                return true;
            }else{
                return false;
            }
        }

        public function check_if_appeal_existed(){
            global $database;
            $escape_user_id = $database->escape_input($this->user_id);
            $escape_date = $database->escape_input($this->date);
            $escape_time_status = $database->escape_input($this->time_status);


            //CHECK IF APPEAL AT SAME DATE AND TIME STATUS ALREADY EXISTED
            
            $check_if_appeal_existed_query = $database->prepare_query("SELECT * FROM appeal WHERE date = ? AND time_status = ? AND user_id = ?");            
            $check_if_appeal_existed_query->bind_param("ssi", $escape_date, $escape_time_status, $escape_user_id, );
            $check_if_appeal_existed_query->execute();
            $result_check_if_appeal_existed = $check_if_appeal_existed_query->get_result();

            if($result_check_if_appeal_existed->num_rows >= 1){
                return true;
            }else{
                return false;
            }
        }


        public function create_appeal(){
            global $database;

            $escape_user_id = $database->escape_input($this->user_id);
            $escape_date = $database->escape_input($this->date);
            $escape_time_status = $database->escape_input($this->time_status);

            $create_appeal_query = $database->prepare_query("UPDATE attendance SET $escape_time_status = '00:00:10'  WHERE date = ? AND user_id = ? AND $escape_time_status = '00:00:00' ");
            $create_appeal_query->bind_param('si', $escape_date, $escape_user_id);
            $create_appeal_query->execute();

            if(mysqli_affected_rows( $database->get_connection() ) === 1){
                return true;
            }else{
                return false;
            }
        }
        

        public function delete_pending_appeal(){
            global $database;
            $escape_user_id = $database->escape_input($this->user_id);
            $escape_date = $database->escape_input($this->date);
            $escape_time_status = $database->escape_input($this->time_status);

            $create_appeal_query = $database->prepare_query("UPDATE attendance SET $escape_time_status = '00:00:00'  WHERE date = ? AND user_id = ? AND $escape_time_status = '00:00:10' ");
            $create_appeal_query->bind_param('si', $escape_date, $escape_user_id);
            $create_appeal_query->execute();

            if(mysqli_affected_rows( $database->get_connection() ) === 1){
                return true;
            }else{
                return false;
            }
        }

        public static function get_current_user_list_of_appeal($user_id){
            global $database;
            $escape_user_id = $database->escape_input($user_id);
            $all_user_appeal_query = $database->prepare_query("SELECT * FROM appeal WHERE user_id = ? ORDER BY id DESC");
            $all_user_appeal_query->bind_param('i', $escape_user_id);
            
            $all_user_appeal_query->execute();
            $result_user_appeal = $all_user_appeal_query->get_result();

            $the_object_array = [];

            while($row = mysqli_fetch_assoc($result_user_appeal)){
                $the_object_array[] = self::instantiation($row);
            }
            return $the_object_array;
        }
//SELECT users.username, deduction.amount, deduction.name FROM users INNER JOIN user_deduction ON users.id = user_deduction.user_id INNER JOIN deduction ON user_deduction.id = deduction.id;
    }

    