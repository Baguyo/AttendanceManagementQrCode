<?php require_once "includes/header.php" ?>
<?php 
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if( isset($_POST['submit_appeal']) ){
            $create_appeal = new Appeal();

            $create_appeal->user_id = $user->id;
            $create_appeal->date = validate_input($_POST['date']);
            $create_appeal->reason = validate_input($_POST['reason']);
            $create_appeal->time_status = validate_input($_POST['time_status']);
            $create_appeal->time = validate_input($_POST['time']) . ':00' ;
            $create_appeal->status = "pending";

            if($create_appeal->check_if_appeal_existed()){
                $error = "Error: Attendance Appeal at " . $create_appeal->date . " " . $create_appeal->time_status;
                $error .= " already existed. Wait for the admin to confirm the appeal, or delete the appeal at ";
                $error .= $create_appeal->date . " " . $create_appeal->time_status . " before adding new appeal";
            }elseif($create_appeal->check_if_attendance_existed()){
                $error = "Error: Attendance Appeal at " . $create_appeal->date . " " . $create_appeal->time_status;
                $error .= " already has valid data.";
                
            }
            else{
                
                if($create_appeal->create_appeal()){
                    $create_appeal->save();
                    $session->message("Attendance appeal on " . $create_appeal->date . " was successfully added");
                    redirect("user_appeal.php");
                }elseif($create_appeal->create_appeal_and_attendance()){

                    $create_appeal->save();
                    $session->message("Attendance appeal on " . $create_appeal->date . " was successfully added");
                    redirect("user_appeal.php");

                }else{
                    $error = "Error: Attendance at " . $create_appeal->date . " " . $create_appeal->time_status . " has already valid data. Contact admin if there's a mistake";
                }
            }

            
            // $sql = "UPDATE attendance SET {$create_appeal->time_status} = Appeal WHERE date = {$create_appeal->date} AND user_id = {$create_appeal->user_id} AND {$create_appeal->time_status} = '00:00:00' ";

        }
    }
?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Submit an appeal</h1>
                    </div>
                                        

                        <div class="row p-3">
                            
                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>

                            <?php if(isset($error)) echo "<p class='p-2 session_message'> " . str_replace("_", " ", $error) ." </p>" ?>
                            
                                
                            <div class="col-lg-12">
                            <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <form action="" method="post" enctype="multipart/form-data">

                                                    

                                                    

                                                    <div class="form-group">
                                                        <label for="">Date:</label>
                                                        <input id="" class="form-control" type="date" name="date"  >
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Reason:</label>
                                                        <input id="" class="form-control" type="text" name="reason" >
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                          <label for="" class="form-label">Time status:</label>
                                                          <select class="form-control" name="time_status" id="">
                                                            <option value="first_time_in">First time in</option>
                                                            <option value="first_time_out">First time out</option>
                                                            <option value="second_time_in">Second time in</option>
                                                            <option value="second_time_out">Second time out</option>
                                                            <option value="third_time_in">Third time in</option>
                                                            <option value="third_time_out">Third time out</option>
                                                          </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Time:</label>
                                                        <input id="" class="form-control" type="time" name="time">
                                                    </div>

                                                    <input type="submit" name='submit_appeal' value="Submit appeal" class="btn update_user_btn">

                                                    </form>
                                            </div>

                                            

                                        </div>
                                            
                                                
                                            
                                            
                                        
                                        
                                    </div>
                                </div>
                                
                                
                            </div>
                            
                            


                                
                            


                                
                            
                        </div>
                    

                </div>
                
        <?php require_once "includes/footer.php" ?>