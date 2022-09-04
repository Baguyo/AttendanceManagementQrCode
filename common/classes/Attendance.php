<?php 
    class Attendance extends DB_object{

        protected static $db_name = "attendance";
        protected static $db_table_fields = array('user_id', 'date', 'first_time_in', 'first_time_out', 'second_time_in', 'second_time_out', 'third_time_in', 'third_time_out');

        public $id;
        public $user_id;    
        public $date;
        public $first_time_in;
        public $first_time_out;
        public $second_time_in;
        public $second_time_out;
        public $third_time_in;
        public $third_time_out;

        protected static $database_data_type = "isssssss";

        protected static $time_field_status = [
            'first time in' => 'first_time_in',
            'first time out' => 'first_time_out',
            'second time in' => 'second_time_in',
            'second time out' => 'second_time_out',
            'third time in' => 'third_time_in',
            'third time out' => 'third_time_out',
        ];


        public static function hours_tofloat($val){
            if (empty($val)) {
                return 0;
            }
            $parts = explode(':', $val);
            return $parts[0] + floor(($parts[1]/60)*100) / 100;
        }

        public static function if_has_appeal( $user_record)  {

            $output = "";

            // return " <td class='appeal_btn text-primary'> {$key[0]} "  . self::change_hours_format( $value ) . " <div class='badge bg-primary text-white'>Appeal</div>  </td>";
            foreach (self::$time_field_status as $value) {
                if($user_record[$value] === "00:00:10"){
                    $output .= " <td class='appeal_btn ' date={$user_record['date']} status={$value} usId={$user_record['user_id']}> "  . self::change_hours_format( $user_record[$value] ) . " <div class='badge bg-primary text-white'>Appeal</div>  </td>";
                }else{
                    $output .= " <td class='appeal_btn '> "  . self::change_hours_format( $user_record[$value] ) . "</td>";
                }
            }
            return $output;
        }




        public static function calculate_user_salary($position_id, $date_from, $date_to){

            $employee_per_department = [];
            
            $position  = Position::find_by_id($position_id);

            $overtime_start = new DateTime($position->time_end);
            

            $user_with_the_position = Position::select_user_with_position($position_id);
            
            

            foreach ($user_with_the_position as $user) {
                $user_attendance =  Attendance::admin_fnc_filter_attendace($date_from, $date_to, $user);
                $employee_per_department[$user] = [];

                $total_regular_hours = 0;
                $total_overtime_hours = 0;
                
                foreach($user_attendance as $attendance){
                    
                    
                    $time_date_format = new DateTime(Attendance::calculate_total_hours($attendance, $attendance['position_id']));

                    $total_hours = self::hours_tofloat($time_date_format->format("H:i"));

                    if($total_hours > 8){

                        foreach (self::$time_field_status as $key => $value) {
                            $time_to_test = new DateTime($attendance[$value]);
                            if( $time_to_test >=  $overtime_start ){
                                if( (float)$time_to_test->format("H:i") - (float)$overtime_start->format("H:i") >=1 ){
                                        $overtime_hours = (float)$time_to_test->format("H:i") - (float)$overtime_start->format("H:i");

                                        $total_overtime_hours += $overtime_hours;            
                                        $total_regular_hours += ( $total_hours - $overtime_hours ) ;
                                }else{
                                    $total_regular_hours += ( $total_hours - 1 ) ;
                                    // $total_regular_hours += 8 ;
                                }
                            }
                        }

                        // $total_overtime_hours = ($total_hours - 8);
                        // $total_regular_hours += 8;
                    }else{

                        if( new DateTime($attendance['first_time_out']) <= $overtime_start &&
                            new DateTime($attendance['second_time_out']) <= $overtime_start &&
                            new DateTime($attendance['third_time_out']) <= $overtime_start )
                        {

                            $total_regular_hours += $total_hours;

                        }else{
                            foreach (self::$time_field_status as $key => $value) {
                                $time_to_test = new DateTime($attendance[$value]);
                                if( $time_to_test >  $overtime_start ){
                                    if( (float)$time_to_test->format("H:i") - (float)$overtime_start->format("H:i") >=1 ){
                                            $overtime_hours = (float)$time_to_test->format("H:i") - (float)$overtime_start->format("H:i");

                                            $total_overtime_hours += $overtime_hours;            
                                            $total_regular_hours += ( $total_hours - $overtime_hours ) ;
                                    }else{
                                        $total_regular_hours += $total_hours ;   
                                    }
                                }
                            }

                        }
                        

                    }
                }
                
                $employee_per_department[$user]['total_overtime_hours'] = $total_overtime_hours;
                $employee_per_department[$user]['total_regular_hours'] =  $total_regular_hours;
                $employee_per_department[$user]['total_salary'] = 
                    ( $employee_per_department[$user]['total_regular_hours'] * $position->rate_per_hour) +
                    ($employee_per_department[$user]['total_overtime_hours'] * $position->rate_per_overtime);
                     ;
                
                
                
            }
            return $employee_per_department;


        }


        public static function count_attendance($object){
            return ( count($object)  );
        }

        public static function change_hours_format($hours){
            if($hours === "00:00:00" || $hours === "00:00:10"){
                return $hours;
            }else{
            $hours = new DateTime($hours);
            return $hours->format('h:i:s');
        }
        }

        public static function change_date_format($date){
            $date = new DateTime($date);
            return $date->format("M-d-Y");
        }

        

        public static function calculate_total_hours($attendance_record  ){

                // $position = Position::find_by_id($position_id);

                // $working_hours_start = new DateTime($position->time_start);


                $first_time_in = "";
                $first_time_out = "";
                $second_time_in = "";
                $second_time_out = "";
                $third_time_in = "";
                $third_time_out = "";

            foreach ($attendance_record as $key => $value) {
                if($key === "first_time_in"){
                    $first_time_in = $value;
                }elseif($key === "first_time_out"){
                    $first_time_out = $value;
                }elseif($key === "second_time_in"){
                    $second_time_in = $value;
                }elseif($key === "second_time_out"){
                    $second_time_out = $value;
                }elseif($key === "third_time_in"){
                    $third_time_in = $value;
                }elseif($key === "third_time_out"){
                    $third_time_out = $value;
                }
            }

            //FIRST TIME IN AND OUT CALCULATION
            $first_time_in = new DateTime($first_time_in);
            $first_time_out = new DateTime($first_time_out);
            $first_time_difference = $first_time_in->diff($first_time_out);
            $first_time_total_spent_hours = $first_time_difference->format("%H:%I:%S");


            //SECOND TIME IN AND OUT CALCULATION
            $second_time_in = new DateTime($second_time_in);
            $second_time_out = new DateTime($second_time_out);
            $second_time_difference = $second_time_in->diff($second_time_out);
            $second_time_total_spent_hours = $second_time_difference->format("%H:%I:%S");

            //THIRD TIME IN AND OUT CALCULATION
            $third_time_in = new DateTime($third_time_in);
            $third_time_out = new DateTime($third_time_out);
            $third_time_difference = $third_time_in->diff($third_time_out);
            $third_time_total_spent_hours = $third_time_difference->format("%H:%I:%S");
            
            // return $second_time_total_spent_hours;

            
             $first_and_second_total_hours =  self::addTime($first_time_total_spent_hours, $second_time_total_spent_hours);

             return self::addTime($first_and_second_total_hours, $third_time_total_spent_hours);
        }

        protected static function  addTime($time1,$time2)
        {
            $x = new DateTime($time1);
            $y = new DateTime($time2);
        
            $interval1 = $x->diff(new DateTime('00:00:00')) ;
            $interval2 = $y->diff(new DateTime('00:00:00')) ;
        
            $e = new DateTime('00:00');
            $f = clone $e;
            $e->add($interval1);
            $e->add($interval2);
            $total = $f->diff($e)->format("%H:%I:%S");
            return $total;

        }
        
        
        public function find_attendance_by_id($id){
            global $database;
            $escape_id = $database->escape_input($id);
            $attendance_by_id_stmt = $database->prepare_query("SELECT * FROM " . self::$db_name. " WHERE id = ?");
            $attendance_by_id_stmt->bind_param("i",$escape_id);
            $attendance_by_id_stmt->execute();
            $result_attendance = $attendance_by_id_stmt->get_result();

            if($result_attendance->num_rows >= 1){
                while($row = $result_attendance->fetch_assoc()){
                    $this->id = $row['id'];
                    $this->user_id = $row['user_id'];
                    $this->date = $row['date'];
                    $this->first_time_in = $row['first_time_in'];
                    $this->first_time_out  = $row['first_time_out'];
                    $this->second_time_in  = $row['second_time_in'];
                    $this->second_time_out = $row['second_time_out'];
                    $this->third_time_in   = $row['third_time_in'];
                    $this->third_time_out  = $row['third_time_out'];
                }
            }
        }

        public static function admin_fnc_today_attendance($sql = NULL){
            global $database;
            if(!$sql){
                
                $get_today_attendance_stmt = $database->query("SELECT attendance.id, attendance.date, attendance.user_id, attendance.first_time_in, attendance.first_time_out, attendance.second_time_in, attendance.second_time_out, attendance.third_time_in, attendance.third_time_out, users.first_name, users.last_name, users.position_id FROM attendance LEFT JOIN users ON attendance.user_id = users.id WHERE DATE(attendance.date) = CURRENT_DATE AND users.user_role = 'user'");
                $all_todays_attendance = array();
                while($row = $get_today_attendance_stmt->fetch_assoc()){
                    $all_todays_attendance[] = $row;
                }
                return $all_todays_attendance;
                
            }else{
                $get_today_attendance_stmt = $database->query($sql);
                $all_todays_attendance = array();
                while($row = $get_today_attendance_stmt->fetch_assoc()){
                    $all_todays_attendance[] = $row;
                }
                return $all_todays_attendance;
            }

            
        }

        public static function admin_fnc_filter_attendace($date_from, $date_to, $user_id){
            global $database;
            $admin_filter_attendance_stmt = $database->prepare_query("SELECT attendance.id, attendance.date, attendance.user_id, attendance.first_time_in, attendance.first_time_out, attendance.second_time_in, attendance.second_time_out, attendance.third_time_in, attendance.third_time_out, users.first_name, users.last_name, users.position_id FROM attendance LEFT JOIN users ON attendance.user_id = users.id WHERE DATE(attendance.date) BETWEEN ? AND ? AND users.id = ?");
            $admin_filter_attendance_stmt->bind_param("ssi", $date_from, $date_to, $user_id);
            $admin_filter_attendance_stmt->execute();
            $admin_filter_attendance_result = $admin_filter_attendance_stmt->get_result();
        
            $all_todays_attendance = array();
            while($row = $admin_filter_attendance_result->fetch_assoc()){
                $all_todays_attendance[] = $row;
            }
            return $all_todays_attendance;
        }


        public static function export_attendance($date_from, $date_to, $user_id){
            global $database;
            global $session;

            $user = User::find_by_id($user_id);

            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$user->first_name $user->last_name $date_from / $date_to.csv");
            $output = fopen("php://output", "w");
            fputcsv($output, array("date", 'first_time_in', 'first_time_out', 'second_time_in', 'second_time_out', 'third_time_in', 'third_time_out', 'total_hours'));
            
            $result = self::filter_date_query($date_from, $date_to, $user_id);
    
            if($result->num_rows >= 1){
                while($row = $result->fetch_assoc()){

                    $sets_of_data = array(
                        
                        self::change_date_format($row['date']),
                        self::change_hours_format($row['first_time_in']),
                        self::change_hours_format($row['first_time_out']),
                        self::change_hours_format($row['second_time_in']),
                        self::change_hours_format($row['second_time_out']),
                        self::change_hours_format($row['third_time_in']),
                        self::change_hours_format($row['third_time_out']),
                        Self::calculate_total_hours($row)
                    );
                    
                    fputcsv($output, $sets_of_data);
                }
            }
            fclose($output);
        }

        public static function find_all_user_attendance_this_month($id){
            $current_month = new DateTime();
            $current_month_first_day = $current_month->format("Y-m")."-1";
            $current_month_last_day = $current_month->format("Y-m")."-31";
            // $result = static::find_by_query("SELECT * FROM `attendance` WHERE DATE(Date_and_time) user_id = {$id} ORDER BY id DESC");
            // return (!empty($result)) ? $result: false; 
            return self::filter_date($current_month_first_day, $current_month_last_day, $id);
        }

        public static function filter_date($date_from, $date_to, $user_id){
            global $database;
            
            $filter_date_result = self::filter_date_query($date_from, $date_to, $user_id);
            $date_filtered_array = array();

            if($filter_date_result->num_rows > 0){
                while( $row = $filter_date_result->fetch_assoc()){
                    $date_filtered_array[] = $row;
                }
                    return $date_filtered_array;
            }else{
                return [];
            }
        }

        private static function filter_date_query($date_from, $date_to, $user_id){
            global $database;
            $date_from = $database->escape_input($date_from);
            $date_to = $database->escape_input($date_to);
            $user_id = $database->escape_input($user_id);

            $filter_date_stmt = $database->prepare_query("SELECT * FROM attendance WHERE DATE(date) BETWEEN ? AND ? AND user_id = ?");
            $filter_date_stmt->bind_param("ssi",$date_from, $date_to,$user_id);
            $filter_date_stmt->execute();
            return $filter_date_result = $filter_date_stmt->get_result();
        }

        public function get_user_id(){
            return $this->user_id;
        }
    }//END OF ATTENDANCE CLASS
?>