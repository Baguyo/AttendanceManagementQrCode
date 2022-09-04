<?php 
    require_once "../function.php";
    require_once "../../../common/classes/Database.php";
    require_once "../../../common/classes/DB_object.php";
    require_once "../../../common/classes/Attendance.php";
    

    
        if(isset($_POST['attId'])){

            
            $attendance = new attendance();
            $attendance->find_attendance_by_id($_POST['attId']);

            
            

            $fI = validate_input($_POST['fI']);
            $fO = validate_input($_POST['fO']);

            $sI = validate_input($_POST['sI']);
            $sO = validate_input($_POST['sO']);

            $tI = validate_input($_POST['tI']);
            $tO = validate_input($_POST['tO']);


            // echo $attendance->id;
            $attendance->first_time_in =  $fI;

            echo $attendance->first_time_in;

            $attendance->first_time_out = $fO;
            $attendance->second_time_in = $sI;
            $attendance->second_time_out =$sO;
            $attendance->third_time_in =  $tI;
            $attendance->third_time_out = $tO;


            $attendance->update();
        }
    
?>