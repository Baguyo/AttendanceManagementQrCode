<?php require_once "includes/header.php" ?>
<?php 
$current_month = new DateTime();
$current_month_first_day = $current_month->format("Y-m")."-1";
$current_month_last_day = $current_month->format("Y-m")."-31";
$user_attendance = Attendance::find_all_user_attendance_this_month($session->get_user_id()); 
?>        
<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['filter_date'])){
            $date_from =  validate_input($_POST['date_from']);
            $date_to =  validate_input($_POST['date_to']);
            $date_filtered = Attendance::filter_date($date_from, $date_to, $session->get_user_id());

            
        }
    }
?>


                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">My Attendance</h1>
                    </div>
                    

                    
                        <div class="row">
                            <div class="col-lg-12 p-3">
                                <form action="" method="post">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <input id="my-input" class="form-control" type="date" name="date_from">
                                            </div>
                                        </div>
                                        <h4>to</h4>
                                        <div class="col">
                                            <div class="form-group">
                                                <input id="my-input" class="form-control" type="date" name="date_to">
                                            </div>
                                        </div>
                                        <div class="col">  
                                            <input type="submit" name="filter_date" value="Filter" class="btn filter_date">
                                        </div>
                                    </div>
                                </form>
                                <table class="table table-light table-hover table-bordered table-responsive-lg">

                                    <form method="post" action="export_attendance.php">
                                        <input type="text" name="date_from" value="<?= (isset($date_from)) ? $date_from : $current_month_first_day ?>" hidden>
                                        <input type="text" name="date_to" value="<?= (isset($date_to)) ? $date_to : $current_month_last_day ?>" hidden>
                                        <input type="submit" name="btn_export" value="Export as CSV" class="btn mb-2 export_btn" >
                                    </form>

                                <!-- <h1>My Record</h1> -->
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>IN</th>
                                            <th>OUT</th>
                                            <th>IN</th>
                                            <th>OUT</th>
                                            <th>IN</th>
                                            <th>OUT</th>
                                            <th>HOURS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(isset($date_filtered)){
                                                if($date_filtered){


                                                    foreach ($date_filtered as $dates) {
                                                        echo "<tr>";
                                                        echo "<td> <h4 class=''><span class=' '> " . Attendance::change_date_format($dates['date']) . " </span> </h4> </td>";
                                                        echo "<td>" . Attendance::change_hours_format($dates['first_time_in']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($dates['first_time_out']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($dates['second_time_in']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($dates['second_time_out']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($dates['third_time_in']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($dates['third_time_out']) . "</td>";
                                                        echo "<td> " . Attendance::calculate_total_hours($dates) ." </td>";
                                                        echo "</tr>";
                                                    }
                                                }else{
                                                    echo "<tr>";
                                                        echo "<td colspan='8' class='text-center'> <h3>NO DATA FOR SELECTED DATE</h3> </td>";
                                                    echo "</tr>";
                                                }

                                            }
                                            else{

                                                foreach ($user_attendance as $attendance) {
                                                    echo "<tr>";
                                                        echo "<td> <h4 class=''><span class=' '> " . Attendance::change_date_format($attendance['date']) . " </span> </h4> </td>";
                                                        echo "<td>" . Attendance::change_hours_format($attendance['first_time_in']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($attendance['first_time_out']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($attendance['second_time_in']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($attendance['second_time_out']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($attendance['third_time_in']) . "</td>";
                                                        echo "<td>" . Attendance::change_hours_format($attendance['third_time_out']) . "</td>";
                                                        echo "<td> " . Attendance::calculate_total_hours($attendance) ." </td>";
                                                    echo "</tr>";
                                                }
                                                
                                            
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                        
                        
                    

                </div>
                
        <?php require_once "includes/footer.php" ?>