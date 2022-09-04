<?php  require_once "../function.php" ?>
<?php  require_once "../../../common/classes/Database.php" ?>
<?php  require_once "../../../common/classes/DB_object.php" ?>
<?php  require_once "../../../common/classes/Deduction.php" ?>

<?php 

    



    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['deduction_approve']) && isset($_POST['user_add_deduction'])){
            $deduction_to_approve_id = validate_input($_POST['deduction_approve']);
            $user_to_add_deduction = validate_input($_POST['user_add_deduction']);

            Deduction::add_deduction($user_to_add_deduction, $deduction_to_approve_id);

            echo $deduction_to_approve_id;

        }

        elseif(isset($_POST['deduction_delete'])){
            $deduction_to_delete_id = validate_input($_POST['deduction_delete']);
            Deduction::delete_deduction_pivot_table($deduction_to_delete_id);
            
            // echo "pota";
        }
    }