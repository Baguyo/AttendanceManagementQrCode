<?php require_once "includes/header.php" ?>
<?php 


    if(empty($_GET['pId']) || !isset($_GET['pId']) ){
        die();
    }else{
        $position_id = validate_input($_GET['pId']);
        $position_to_edit = Position::find_by_id($position_id);
    }

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if( isset($_POST['update_position']) ){
            
            $position_name = validate_input($_POST['position']);
            $rate_per_hour = validate_input($_POST['rate_per_hour']);
            $rate_per_overtime = validate_input($_POST['rate_per_overtime']);
            $department_id = validate_input($_POST['department']);
            $time_start = validate_input($_POST['time_start']);
            $time_end = validate_input($_POST['time_end']);

            
            $position_to_edit->position_name     = $position_name;
            $position_to_edit->rate_per_hour     = $rate_per_hour;
            $position_to_edit->rate_per_overtime = $rate_per_overtime;
            $position_to_edit->department_id     = $department_id;
            $position_to_edit->time_start     = $time_start;
            $position_to_edit->time_end     = $time_end;

            
            $session->message($position_to_edit->position_name . " was successfully updated");
            $position_to_edit->save();
            redirect("position_list.php");

        }
    }
?>
<?php $department = Department::find_all(); ?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Edit position</h1>
                    </div>
                                        

                        <div class="row p-3">
                            
                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>

                            
                            
                                
                            <div class="col-lg-12">
                            <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <form action="" method="POST" enctype="multipart/form-data">


                                                    <div class="form-group">
                                                        <label for="my-select">Department:</label>
                                                        <select id="my-select" class="form-control" name="department">
                                                            <?php foreach($department as $dpt): ?>
                                                                <?php if($dpt->id === $position_to_edit->department_id): ?>
                                                                    <option value="<?= $dpt->id ?>" selected ><?= $dpt->name ?></option>
                                                                <?php else: ?>
                                                                    <option value="<?= $dpt->id ?>" ><?= $dpt->name ?></option>
                                                                <?php endif; ?>
                                                                
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Position:</label>
                                                        <input id="" class="form-control" type="text" name="position"  autofocus required value="<?= $position_to_edit->position_name ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Rate per hour:</label>
                                                        <input id="" class="form-control" type="number" name="rate_per_hour" required value="<?= $position_to_edit->rate_per_hour ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Overtime rate per hour</label>
                                                        <input id="" class="form-control" type="number" name="rate_per_overtime"  required value="<?= $position_to_edit->rate_per_overtime ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Time start</label>
                                                        <input id="" class="form-control" type="time" name="time_start"  required value="<?= $position_to_edit->time_start ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Time end</label>
                                                        <input id="" class="form-control" type="time" name="time_end"  required value="<?= $position_to_edit->time_end ?>">
                                                    </div>


                                                    <input type="submit" name='update_position' value="Update position" class="btn update_user_btn">

                                                </form>
                                            </div>

                                            

                                        </div>
                                            
                                                
                                            
                                            
                                        
                                        
                                    </div>
                                </div>
                                
                                
                            </div>
                            
                            


                                
                            


                                
                            
                        </div>
                    

                </div>
                
        <?php require_once "includes/footer.php" ?>