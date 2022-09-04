<?php 

require_once "includes/function.php";
require_once "includes/init.php";


?>
<?php 
   // if(isset($_POST['username']) && isset($_POST['password'])){
   //    $username = validate_input($_POST['username']);
   //    $password = validate_input($_POST['password']);
      // if(User::check_time_in_user($username, $password)){
   //       echo "found";
   //    }else{
   //       echo "not found";
   //    }
   // }
   //  elseif(isset($_FILES)){
   //    $user = User::find_by_id($_SESSION['attendance_user_id']);
   //    // $filename =  $user->username . 'pic_'.date('YmdHis') . '.jpeg';
   //    // $url = '';
   //    // if( move_uploaded_file($_FILES['webcam']['tmp_name'],'includes/'.$filename) ){
   //    //    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/upload/' . $filename . $sign_user->username;
   //    // }
      // if(User::save_user_time_and_image($user,$_FILES['webcam'])){
   //       echo "good assdsad";
   //    }else{
   //       echo "badasdsda";
   //    }

   //  }

   if($_SERVER['REQUEST_METHOD'] == "POST"){
      if(isset($_POST['qr_code'])){
         $qr_code = validate_input( $_POST['qr_code'] );

         $found_user = User::check_time_in_user($qr_code);

         if($found_user){

            // echo User::save_user_attendance($found_user);

            if(User::save_user_attendance($found_user)){
               echo "{$found_user->first_name} {$found_user->last_name} was successfully time in";
            }else{
               echo "failed";
            }
            
         }else{
            echo "failed";
            
         }

      }
   }