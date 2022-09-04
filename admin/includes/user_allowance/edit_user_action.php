<?php  require_once "../function.php" ?>
<?php  require_once "../../../common/classes/Database.php" ?>
<?php  require_once "../../../common/classes/DB_object.php" ?>
<?php  require_once "../../../common/classes/Allowance.php" ?>

<?php 

    



    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['allowance_approve']) && isset($_POST['user_add_allowance'])){
            $allowance_to_approve_id = validate_input($_POST['allowance_approve']);
            $user_to_add_allowance = validate_input($_POST['user_add_allowance']);

            Allowance::add_allowance($user_to_add_allowance, $allowance_to_approve_id);

            echo $allowance_to_approve_id;

        }

        elseif(isset($_POST['allowance_delete'])){
            $allowance_to_delete_id = validate_input($_POST['allowance_delete']);
            Allowance::delete_allowance_pivot_table($allowance_to_delete_id);
            
            // echo "pota";
        }
    }