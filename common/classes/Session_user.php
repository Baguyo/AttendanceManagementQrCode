<?php 
    Class Session{
       
        private $id;
        public $logged_in;
        public $user_role;

        public $message;

        private $attendance_user_id;


        public function __construct()
        {
            session_start();
            $this->check_if_logged_in();
            
            // $this->attendance_user();
        }

        public function get_user_id(){
            return $this->id;
        }

        public function login($user){
            if($user){
                $this->id = $_SESSION['id'] = $user->id;
                $this->user_role = $_SESSION['user_role'] = $user->user_role;
                $this->logged_in = true;
            }
        }


        public function attendance_user(){
            if(isset($_SESSION['attendance_user'])){
                $this->attendance_user_id = $_SESSION['attendance_user_id'];
            }
        }

        public function check_if_logged_in(){
            if(isset($_SESSION['id']) && isset($_SESSION['user_role'])){
                $this->id = $_SESSION['id'];
                $this->user_role = $_SESSION['user_role'];
                $this->logged_in = true;
            }else{
                unset($this->id);
                unset($this->user_role);
                $this->logged_in = false;
            }
        }

        public function is_logged_in(){
            return $this->logged_in;
        }

        public function logout(){
            session_destroy();
            unset($this->id);
            unset($this->user_role);
            $this->logged_in = false;
        }

        public function message($message){
            if(!empty($message)){
                $_SESSION['message'] = $message;
            }
        }

        public function check_message(){
            if(isset($_SESSION['message'])){
                $this->message = $_SESSION['message'];
                unset($_SESSION['message']);
            }else{
                $this->message = "";
            }
        }
        
        // public function display_message(){
        //     if(!empty($this->message)){
        //         return $this->message;
        //         unset($_SESSION['message']);
        //     }else{
        //         return false;
        //     }
        // }
        
    }

    $session = new Session();
    $session->check_message();
    //  END OF SESSION CLASS
