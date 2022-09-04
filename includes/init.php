<?php

    date_default_timezone_set('Asia/Manila');
    defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
    defined("SITE_ROOT") ? null : define("SITE_ROOT", "C:". DS . "xampp". DS . "htdocs" . DS . "AttendanceManagementQrCode");
    defined("INCLUDES_PATH") ? null : define("INCLUDES_PATH", SITE_ROOT.DS."admin".DS."includes") ;

    
    require_once "common/classes/Database.php";
    require_once "common/classes/Session_user.php";
    require_once "common/classes/DB_object.php";
    require_once "common/classes/User.php";
    require_once "common/classes/Attendance.php";
    require_once "common/classes/Pagination.php";
    require_once "common/classes/Appeal.php";
    require_once "common/classes/Deduction.php";
    
?>