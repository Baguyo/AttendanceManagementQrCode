<?php 

    function validate_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlentities($data);
        return $data;
    }

    function redirect($location){
        header("Location: {$location}");
    }
    
    spl_autoload_register(function($class) {
        require_once '../common/classes/'.$class.'.php';
    });