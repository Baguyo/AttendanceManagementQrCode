
<!DOCTYPE html>
<?php require_once "init.php" ?>
<?php 
    if(!$session->is_logged_in()){
        redirect("../index.php");
    }
    $user = User::find_by_id($session->get_user_id());

    if($user->user_role === "admin"){
        die();
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ADMIN</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- FONT AWESOME -->
        <!-- <script src="https://kit.fontawesome.com/573a5c3258.js" crossorigin="anonymous"></script> -->
        
        <script src="https://kit.fontawesome.com/573a5c3258.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <!-- BOOTSTRAP  -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- CUSTOM CSS -->
        <link rel="stylesheet" href="css/style.css">

        
  

    

    </head>
    <body>
        <div class="wrapper">