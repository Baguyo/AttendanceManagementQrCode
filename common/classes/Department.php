<?php 
    class Department extends DB_object{


        protected static $db_name = "department";
        protected static $db_table_fields = array('name');

        public $id;
        public $name;
        
    
        public static $question_mark_embed = "?";
        protected static $database_data_type = 's';


            }
