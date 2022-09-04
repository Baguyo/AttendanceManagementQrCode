<?php 
    class DB_object{

        protected static $db_name = "users";
        protected static $db_table_fields = array( 'username', "password", 'first_name', 'last_name', 'user_role');

        public $id;
        public $username;
        public $password;
        public $first_name;
        public $last_name;
        public $user_role;


        public static $question_mark_embed;

        protected static $database_data_type;

        //FILES ERROR
        public $error = array();
        public $upload_error_array = array(
            UPLOAD_ERR_OK => 'There is no error, the file uploaded with success',
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
        );

        public static function find_by_id( $id){
            $result = static::find_by_query("SELECT * FROM " . static::$db_name . " WHERE id = $id");
            return (!empty($result)) ? array_shift($result) : false;
        }

        public static function find_all(){
            $result = static::find_by_query("SELECT * FROM ". static::$db_name);
            return (!empty($result)) ? $result: false;  
        }

        public static function find_by_query($sql){
            global $database;
            $result_query = $database->query($sql);
            $the_object_array = [];
            while($row = mysqli_fetch_assoc($result_query)){
                $the_object_array[] = static::instantiation($row);
            }
            return $the_object_array;
        }

        public static function instantiation($row){
            $get_called_class = get_called_class();
            $called_object = new $get_called_class;

            foreach($row as $attribute => $value){
                if($called_object->has_attribute($attribute)){
                    $called_object->$attribute = $value;
                }
            }
            return $called_object;
        }

        public function has_attribute($attribute){
            $object_properties = get_object_vars($this);
            return array_key_exists($attribute, $object_properties);
        }

         
        public function save(){
             (!empty($this->id)) ? $this->update() : $this->create();
        }

        public function update(){
            global $database;
            $update_prepare_query = $database->prepare_query("UPDATE ". static::$db_name ." SET ".implode("=?,", static::$db_table_fields) . " =? WHERE id = {$this->id}");
            $get_data_types = $this->get_data_type();
            $properties = $this->get_properties();

            $update_prepare_query->bind_param(static::$database_data_type, ...$properties);
            if($update_prepare_query->execute()){
                return ($database->get_connection()->affected_rows == 1) ? true : false;
            }
        }

        public function create(){
            global $database;
            $prepare_query = $database->prepare_query("INSERT INTO " . static::$db_name ." (".implode(",", static::$db_table_fields) .") VALUES (". static::$question_mark_embed .")");
            // $get_data_types = $this->get_data_type();
            $properties = $this->get_properties();

            $prepare_query->bind_param(static::$database_data_type, ...$properties);
            if($prepare_query->execute()){
                $this->id = $database->get_insert_id();
                return true;
            }else{
                return false;
            }
        }
        
        public function delete(){
            global $database;
            $delete_prepare_query = $database->prepare_query("DELETE FROM ". static::$db_name ." WHERE id = ?");
            $escape_id = $database->escape_input($this->id);
            $delete_prepare_query->bind_param("i", $escape_id);
            if($delete_prepare_query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function get_data_type(){
            $data_types = "";
            foreach(static::$db_table_fields as $db_fields){
                if(property_exists($this, $db_fields)){
                    
                    $data_type = gettype($this->$db_fields);
                    if($data_type == "string"){
                        $data_types.= "s";
                    }elseif($data_type == "integer"){
                        $data_types.= "i";
                    }
                    
                }
            }
            return $data_types;
        }

        public function get_properties(){
            global $database;
            $properties = array();
            foreach(static::$db_table_fields as $db_fields){
                
                if(property_exists($this, $db_fields)){
                    $properties[] = $database->escape_input($this->$db_fields);
                }
            }
            
            return $properties;
        }

        public static function count_all(){
            global $database;
            $sql = "SELECT COUNT(*) FROM " . static::$db_name;
            $result_row = $database->query($sql);
            $row = $result_row->fetch_array();
            return array_shift($row);
        }

    }
?>