<?php 

    class User extends DB_object{

        protected static $db_name = "users";
        protected static $db_table_fields = array('username', "password", 'first_name', 'last_name', 'user_role', 'user_image', 'qr_code', 'qrcode_path', 'position_id');

        public $id;
        public $username;
        public $password;
        public $first_name;
        public $last_name;
        public $user_role;
        public $user_image;
        public $qr_code;
        public $qrcode_path;
        public $position_id;


        public static $question_mark_embed = "?,?,?,?,?,?,?,?,?";
        protected static $database_data_type = "ssssssssi";
    
        public $tmp_name;
        private $upload_directory = "..".DS."admin".DS.'images';
        private $img_placeholder = "https://place-hold.it/128x128?text=User+image";
        private $qrcode_placeholder = "https://place-hold.it/128x128?text=QR+code";




        

        public function create_user_allowance($allowance){
            global $database;
            if(!empty($allowance) || is_array($allowance)){

                $escape_id = $database->escape_input($this->id);

                foreach($allowance as $item){

                    $insert_user_deduction_query = $database->prepare_query("INSERT INTO user_allowance (user_id, allowance_id) VALUES ( ? , ?)");

                    $escape_deduction_id = $database->escape_input($item);

                    $insert_user_deduction_query->bind_param("ii", $escape_id, $escape_deduction_id);
                    $insert_user_deduction_query->execute();
                }
            }else{
                return false;
            }
        }

        

        public function create_user_deduction($deductions){
            global $database;
            if(!empty($deductions) || is_array($deductions)){

                $escape_id = $database->escape_input($this->id);

                foreach($deductions as $deduction){

                    $insert_user_deduction_query = $database->prepare_query("INSERT INTO user_deduction (user_id, deduction_id) VALUES ( ? , ?)");

                    $escape_deduction_id = $database->escape_input($deduction);

                    $insert_user_deduction_query->bind_param("ii", $escape_id, $escape_deduction_id);
                    $insert_user_deduction_query->execute();
                }
            }else{
                return false;
            }
        }


        public function delete()
        {
            global $database;
            $delete_user_query = $database->prepare_query("DELETE FROM users WHERE id = ?");
            $escape_id = $database->escape_input($this->id);

            // DELETE QR CODE IMAGE
            $qr_code = $this->upload_directory.DS.$this->qrcode_path;
            if(is_file($qr_code)){
                unlink($this->upload_directory.DS.$this->qrcode_path);
            }

            $user_image = $this->upload_directory.DS.$this->user_image;
            if(is_file($user_image)){
                unlink($user_image);
            }

            $delete_user_query->bind_param('i', $escape_id);
            if($delete_user_query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function set_file($file){
            // if(empty($file) || !$file || !is_array($file)){
            //     $this->error[] = "No file uploaded";
            //     return false;
            // }
            if($file['error'] != 0){
                $this->error[] = $this->upload_error_array[$file['error']];
                return false;
            }else{
                
                $previous_image_to_delete = $this->upload_directory.DS.$this->user_image;

                if(is_file($previous_image_to_delete)){
                    unlink($previous_image_to_delete);
                }
                    $this->tmp_name = $file['tmp_name'];
                    $this->user_image = basename($file['name']);
                    return true;
            }
        }

        public function save_user_image(){

            if(!empty($this->error)){
                return false;
            }

            if(empty($this->user_image || $this->tmp_name)){
                $this->error[] = "File was unable to upload";
                return false;
            }

            $target_path = $this->upload_directory.DS.$this->user_image;

            if(move_uploaded_file($this->tmp_name, $target_path)){
                unset($this->tmp_name);
                return true;
            }else{
                $this->error[] = "Unable to upload file due to file permission";
            }


        }


        public static function save_user_attendance(User $user){
            global $database;            

            
            $found_user = $user;

            $current_date = date('Ymd');

            $current_time = date('H:i:s');

             
            $check_if_has_attendance = $database->prepare_query("SELECT * FROM attendance WHERE attendance.date = ? AND attendance.user_id = ?");
            $check_if_has_attendance->bind_param('si', $current_date, $found_user->id);
            $check_if_has_attendance->execute();

            $result_check_if_has_attendance = $check_if_has_attendance->get_result();

            if($result_check_if_has_attendance->num_rows == 1){

               $row =  $result_check_if_has_attendance->fetch_assoc();
               $user_attendance = Attendance::find_by_id($row['id']);

               

               $user_attendance_properties = get_object_vars($user_attendance);

               foreach($user_attendance_properties as $properties_key => $properties_value){
                    if($properties_value == "00:00:00" ){
                        
                        $user_attendance->$properties_key = $current_time;
                        $user_attendance->save();
                        return $user_attendance->$properties_key;    
                    }
               }
               

            }else{
                $insert_new_attendance = $database->prepare_query( "INSERT INTO attendance(user_id, date, first_time_in) VALUES(?, ?, ?)" );
                $insert_new_attendance->bind_param('iss', $found_user->id, $current_date, $current_time);
                $insert_new_attendance->execute();
                return true;
            }

            // $current_date_time = date('YmdHis');
            // $time_in_image_filename = $user->username.$current_date_time.$img_file['name'];

            // $save_user_time_and_img_stmt = $database->prepare_query("INSERT INTO attendance(user_id, Date_and_time, time_in_image) VALUES(?,?,?)");
            // $save_user_time_and_img_stmt->bind_param("iss", $user->id, $current_date_time, $time_in_image_filename);

            

            // if(move_uploaded_file($img_file['tmp_name'], 'admin/images/'.$time_in_image_filename)){
            //     if($save_user_time_and_img_stmt->execute()){
            //         return true;
            //     }else{
            //         return false;
            //     }
            // }else{
            //     return false;
            // }
                
            
        }

        public static function check_time_in_user($qr_code){
            
            global $database;
            $qr_code = $database->escape_input($qr_code);
            $qr_code_query = $database->prepare_query("SELECT id FROM users WHERE qr_code = ?");
            $qr_code_query->bind_param('s', $qr_code);
            $qr_code_query->execute();
            $result_qr_code_query = $qr_code_query->get_result();

            if($result_qr_code_query->num_rows === 1){
                
                $row = $result_qr_code_query->fetch_assoc();
                $user = self::find_by_id($row['id']);
                return $user;
                

            }else{
                return false;
            }

        }



        public static function verify_user($username, $password){
            global $session;
            // $verify_user_stmt->store_result();
            $result = self::check_if_user_exist_query($username, $password);

            if($result->num_rows == 1){
                
                while($row = $result->fetch_assoc()){
                    $user = self::find_by_id($row['id']);
                    $session->login($user);
                    return $user;
                }
                // return true;
            }else{
                return false;
            }
        }

        public static function check_if_user_exist_query($username, $password){
            global $database;

            $escape_username = $database->escape_input($username);
            $escape_password = $database->escape_input($password);
            //CHECK IF RECORD EXIST
            $check_record_stmt = $database->prepare_query("SELECT * FROM users WHERE username = ? LIMIT 1");
            $check_record_stmt->bind_param("s",$escape_username);
            $check_record_stmt->execute();

            return $check_record_stmt->get_result();
        }

        public function display_user_photo(){   
            return (empty($this->user_image)) ? $this->img_placeholder : $this->upload_directory.DS.$this->user_image;
        }

        public function display_user_qr_code(){   
            return (empty($this->qrcode_path)) ? $this->qrcode_placeholder : $this->upload_directory.DS.$this->qrcode_path;
        }

        public static function download_qr_code($file){
            // $user = self::find_by_id($id);

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file)); 
            header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            ob_clean();
            header('Content-Length: ' . filesize($file));
            // flush(); // Flush system output buffer
            readfile($file);
                exit;
        }

       public function admin_fnc_get_all_users(){
           global $database;
           $admin_get_all_user_stmt = $database->query("SELECT * FROM users WHERE user_role = 'user'");
           $all_users_only_array = array();
           while($row = $admin_get_all_user_stmt->fetch_assoc()){
               $all_users_only_array[] = self::instantiation($row);
           }
           return $all_users_only_array;
       }
        

      
       
    } //END OF USER CLASS

?>