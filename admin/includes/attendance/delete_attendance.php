
<?php require_once "../function.php" ?>
<?php defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR); ?>
<?php  require_once "../../../common/classes/Database.php" ?>

<?php  require_once "../../../common/classes/DB_object.php" ?>

<?php  require_once "../../../common/classes/Session_user.php" ?>
<?php  require_once "../../../common/classes/Attendance.php" ?>
<?php  require_once "../../../common/classes/User.php" ?>

<?php 
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(!empty($_POST['attendance_id']) && !empty($_POST['user_id'])){
            $attendance_id = validate_input($_POST['attendance_id']);
            $user_id = (int)validate_input($_POST['user_id']);

            $user = User::find_by_id($user_id);

            if($user){
                $attendance = new Attendance();
                $attendance->find_attendance_by_id($attendance_id);
                $session->message( $user->first_name . " " . $user->last_name . " Attendance on " . $attendance->date . " was successfully deleted" );
                $attendance->delete();
            }else{
                die();
            }

            

        }
    }
?>