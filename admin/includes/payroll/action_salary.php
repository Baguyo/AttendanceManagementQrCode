<?php 
    
    

    date_default_timezone_set('Asia/Manila');
    defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
    defined("SITE_ROOT") ? null : define("SITE_ROOT", "C:". DS . "xampp". DS . "htdocs" . DS . "AttendanceManagementQrCode");
    defined("INCLUDES_PATH") ? null : define("INCLUDES_PATH", SITE_ROOT.DS."admin".DS."includes") ;
    require_once "../function.php";
    require_once "../../../common/classes/Database.php";
    require_once "../../../common/classes/DB_object.php";
    require_once "../../../common/classes/Session_user.php";
    require_once "../../../common/classes/User.php";
    require_once "../../../common/classes/Position.php";
    require_once "../../../common/classes/Salary.php";
    require_once "../../../common/classes/Allowance.php";
    require_once "../../../common/classes/Deduction.php";
    require_once "../../../common/classes/Attendance.php";

    if($_SERVER['REQUEST_METHOD'] === "POST"){

        if( isset($_POST['usId']) && !empty($_POST['usId']) && $_POST['action'] === "save" ){

            $user_salary = validate_input($_POST['user_salary']);
            $date_from = validate_input($_POST['date_from']);
            $date_to = validate_input($_POST['date_to']);
            $user_id = validate_input($_POST['usId']);

            $user_salary_save = User::find_by_id($user_id);

            $position = Position::find_by_id($user_salary_save->position_id);

            $salary = new Salary();

            $salary->user_id = $user_id;
            $salary->date_from = $date_from;
            $salary->date_to = $date_to;
            $salary->position = $position->position_name;
            $salary->total_salary = $user_salary;

            if($salary->create()){
                $session->message(" Employee {$user_salary_save->first_name } " . $user_salary_save->last_name . " salary was successfully save" );
            }else{
                $session->message(" Salary Error! Please try again  Employee name: {$user_salary_save->first_name } " . $user_salary_save->last_name . " salary" );
            }

        }
        elseif( isset($_POST['usId']) && !empty($_POST['usId']) && $_POST['action'] === "print_and_save" ){

            $user_salary = validate_input($_POST['user_salary']);
            $date_from = validate_input($_POST['date_from']);
            $date_to = validate_input($_POST['date_to']);
            $user_id = validate_input($_POST['usId']);

            $user_salary_save = User::find_by_id($user_id);

            $position = Position::find_by_id($user_salary_save->position_id);

            $salary = new Salary();

            $salary->user_id = $user_id;
            $salary->date_from = $date_from;
            $salary->date_to = $date_to;
            $salary->position = $position->position_name;
            $salary->total_salary = $user_salary;

            if($salary->create()){
                echo "save";
                $session->message(" Employee {$user_salary_save->first_name } " . $user_salary_save->last_name . " salary was successfully save" );
            }else{
                $session->message(" Salary Error! Please try again  Employee name: {$user_salary_save->first_name } " . $user_salary_save->last_name . " salary" );
            }

        }
        
    }else{
        die();
    }

    