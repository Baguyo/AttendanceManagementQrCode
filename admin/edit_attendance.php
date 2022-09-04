<?php require_once "includes/header.php" ?>
<?php 
    
    if($user->user_role === 'user' || empty($_GET['attId']) || empty($_GET['usId'])){
        die();
    }
    
    $user_to_edit = User::find_by_id( validate_input($_GET['usId']) );
    $attendance = new Attendance;
    $attendance->find_attendance_by_id( validate_input( $_GET['attId'] ) );


    if( isset( $_POST['update_attendance'] ) ){
        $attendance->date = validate_input( $_POST['date'] );
        $attendance->first_time_in = validate_input( $_POST['first_time_in'] );
        $attendance->first_time_out = validate_input( $_POST['first_time_out'] );
        $attendance->second_time_in = validate_input( $_POST['second_time_in'] );
        $attendance->second_time_out = validate_input( $_POST['second_time_out'] );
        $attendance->third_time_in = validate_input( $_POST['third_time_in'] );
        $attendance->third_time_out = validate_input( $_POST['third_time_out'] );
        
        $attendance->save();
        redirect("edit_attendance.php?attId={$attendance->id}&usId={$attendance->user_id}");
        $session->message($user_to_edit->first_name . " " . $user_to_edit->last_name . " attendance on " . $attendance->date . " was successfully updated");

    }

?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Edit Attendance</h1>
                    </div>
                                        

                        <div class="row">
                            <div class="col-lg-12 p-3">
                                <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>
                            <div class="col-lg-10 offset-lg-1">
                            <div class="card">
                                    <div class="card-body">
                                        
                                                <form action="" method="POST" enctype="multipart/form-data">

                                            
                                                <div class="alert alert-success" role="alert">
                                                    <strong>Note! Time are formatted 24 hour</strong>
                                                </div>
                                                <div class="alert alert-success" role="alert">
                                                    <strong> Note! Time display format is Hours/Minutes/Seconds</strong>
                                                </div>
                                            
                                                <h3 class="edit-attendance-header"> <?= $user_to_edit->first_name . " " . $user_to_edit->last_name ?> </h3>
                                                    

                                                    <div class="form-group">
                                                        <label for="">Date</label>
                                                        <input id="" class="form-control" type="text" name="date" value="<?php echo $attendance->date; ?>" >
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="">First time in:</label>
                                                        <input id="" class="form-control" type="text" name="first_time_in" value="<?=$attendance->first_time_in ?>">
                                                        
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">First time out:</label>
                                                        <input id="" class="form-control" type="text" name="first_time_out" value="<?= $attendance->first_time_out ?>">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="">Second time in:</label>
                                                        <input id="" class="form-control" type="text" name="second_time_in" value="<?= $attendance->second_time_in ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Second time out:</label>
                                                        <input id="" class="form-control" type="text" name="second_time_out" value="<?= $attendance->second_time_out ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Third time in:</label>
                                                        <input id="" class="form-control" type="text" name="third_time_in" value="<?= $attendance->third_time_in ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Third time out:</label>
                                                        <input id="" class="form-control" type="text" name="third_time_out" value="<?= $attendance->third_time_out ?>">
                                                    </div>
                                                    

                                                    <input type="submit" name='update_attendance' value="Update attendance" class="btn update_user_btn">

                                                </form>
                                            
                                            
                                        
                                        
                                    </div>
                                </div>
                            </div>
                                



                                
                        </div>
                    

                </div>
                
        <?php require_once "includes/footer.php" ?>