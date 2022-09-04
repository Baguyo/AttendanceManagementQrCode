<?php require_once "init.php" ?>
<?php 
    
        if(isset($_GET['usid'])){
            $user_id = validate_input($_GET['usid']);
            $user_to_delete = User::find_by_id($user_id);
            if($user_to_delete){
                if($user_to_delete->delete()){
                    $session->message("User was successfully deleted");
                    redirect("users.php");
                }
            }
        }
    
?>
