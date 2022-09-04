<?php require_once "init.php" ?>
<?php 
    if(isset($_POST['btn_export'])){
        global $database;
        global $session;
        $date_from = validate_input($_POST['date_from']);
        $date_to = validate_input($_POST['date_to']);
        $user_id = $session->get_user_id();

        Attendance::export_attendance($date_from, $date_to, $user_id);   
    }

   
?>