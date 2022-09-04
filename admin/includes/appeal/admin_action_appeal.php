<?php  require_once "../function.php" ?>
<?php  require_once "../../../common/classes/Database.php" ?>
<?php  require_once "../../../common/classes/DB_object.php" ?>
<?php  require_once "../../../common/classes/Appeal.php" ?>
<?php 
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if( isset($_POST['appId_approve']) ){
                $appId_approve =  validate_input($_POST['appId_approve']);
    
                $appeal_to_approve = Appeal::find_by_id($appId_approve);
    
                if($appeal_to_approve->ajax_approve_appeal()){
                    $appeal_to_approve->status = "approve";
                    $appeal_to_approve->save();    
                    echo "<div class='badge bg-success text-white p-2' >  approve </div> ";
                }else{
                    echo "<div class='badge bg-success text-white p-2' >  approve </div> ";
                }
            }
    
            elseif( isset($_POST['appId_denied']) ){
                $appId_denied =  validate_input($_POST['appId_denied']);
                
                // echo "$appId_denied";
    
                $appeal_to_denied = Appeal::find_by_id($appId_denied);
    
                if($appeal_to_denied->ajax_denied_appeal()){
                    echo "<div class='badge bg-danger text-white p-2'  >  denied </div> ";                
                }else{
                    echo "<div class='badge bg-danger text-white p-2'  >  denied </div> ";                
                }
            }
        }