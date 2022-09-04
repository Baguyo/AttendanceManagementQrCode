<?php require_once "includes/header.php" ?>
<?php require_once "phpqrcode/qrlib.php";?>
<?php $department = Department::find_all(); ?>
<?php 
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['add_position'])){
            $add_position = new Position();


            $position_name = validate_input($_POST['position']);
            $rate_per_hour = validate_input($_POST['rate_per_hour']);
            $rate_per_overtime = validate_input($_POST['rate_per_overtime']);
            $department_id = validate_input($_POST['department']);
            $time_start = validate_input($_POST['time_start']);
            $time_end = validate_input($_POST['time_end']);

            
            $add_position->position_name     = $position_name;
            $add_position->rate_per_hour     = $rate_per_hour;
            $add_position->rate_per_overtime = $rate_per_overtime;
            $add_position->department_id     = $department_id;
            $add_position->time_start = $time_start;
            $add_position->time_end = $time_end;

            
            $session->message($add_position->position_name . " was successfully added");
            $add_position->create();
            redirect("position_list.php");

        }
    }
?>
    


                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Add Position</h1>
                    </div>
                                        

                        <div class="row">
                            <div class="col-lg-12 p-3">
                                
                            <div class="col-lg-10 offset-lg-1">
                            <div class="card">
                                    <div class="card-body">
                                        
                                                <form action="" method="POST" enctype="multipart/form-data">


                                                    <div class="form-group">
                                                        <label for="my-select">Department:</label>
                                                        <select id="my-select" class="form-control" name="department" required>
                                                        <option value="" >--SELECT--</option>
                                                            <?php foreach($department as $dpt): ?>
                                                                <option value="<?= $dpt->id ?>" ><?= $dpt->name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Position:</label>
                                                        <input id="" class="form-control" type="text" name="position"  autofocus required>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="">Rate per hour:</label>
                                                        <input id="" class="form-control" type="number" name="rate_per_hour" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Overtime rate per hour</label>
                                                        <input id="" class="form-control" type="number" name="rate_per_overtime"  required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Time start</label>
                                                        <input id="" class="form-control" type="time" name="time_start"  required >
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Time end</label>
                                                        <input id="" class="form-control" type="time" name="time_end"  required >
                                                    </div>
                                                    
                                                    <input type="submit" name='add_position' value="Add position" class="btn update_user_btn">

                                                </form>
                                            
                                            
                                        
                                        
                                    </div>
                                </div>
                            </div>
                                



                                
                        </div>
                    
                        

                </div>
                
        <?php require_once "includes/footer.php" ?>