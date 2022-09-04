<?php require_once "init.php" ?>
<?php 

    if(!isset($_POST['appId']) || empty($_POST['appId'])){
        die();
    }else{
        $appId = validate_input($_POST['appId']);
        
        $appeal_to_delete = Appeal::find_by_id($appId);

        if($appeal_to_delete->status == "pending"){

            $session->message("Attendance Appeal at " . $appeal_to_delete->date . " ". $appeal_to_delete->time_status . " " . " was successfully deleted");
            $appeal_to_delete->delete_pending_appeal();
            $appeal_to_delete->delete();

        }elseif($appeal_to_delete->status == "approve"){
            $session->message("Appeal at" . $appeal_to_delete->date . " ". $appeal_to_delete->time_status . " " . " was successfully deleted");
            $appeal_to_delete->delete();
        }elseif($appeal_to_delete->status == "denied"){
            $session->message("Attendance Appeal at " . $appeal_to_delete->date . " ". $appeal_to_delete->time_status . " " . " was successfully deleted");
            $appeal_to_delete->delete_pending_appeal();
            $appeal_to_delete->delete();
        }

    }

?>