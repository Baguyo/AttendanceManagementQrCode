<?php require_once "includes/header.php" ?>
<?php 

    if($user->user_role === 'user'){
        redirect('index.php');
    }

    $todays_attendance = Attendance::admin_fnc_today_attendance();                            

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET['filter_date'])){
            $user_id = validate_input($_GET['user_id']);
            $date_from =  validate_input($_GET['date_from']);
            $date_to =  validate_input($_GET['date_to']);
            $date_filtered = Attendance::admin_fnc_filter_attendace($date_from, $date_to, $user_id);
        }
    }

    
 
    $todays_attendance = Attendance::admin_fnc_today_attendance();
 
     

?>


                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Check Attendance</h1>
                    </div>
                    

                    
                        <div class="row">

                            

                            <div class="col-lg-12 p-3">

                            

                            <form action="" method="GET">
                                    <div class="form-row">


                                    

                                        <div class="col">
                                            <div class="form-group">
                                                <select id="my-select" class="form-control" name="user_id" required>
                                                    <option value="">--SELECT--</option>
                                                    <?php 
                                                        $admin_user = new User();
                                                        $all_user_only = $admin_user->admin_fnc_get_all_users();
                                                        foreach($all_user_only as $users){
                                                            echo "<option value=$users->id> $users->first_name $users->last_name </option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <input id="my-input" class="form-control" type="date" name="date_from" required>
                                            </div>
                                        </div>
                                        <h4>to</h4>
                                        <div class="col">
                                            <div class="form-group">
                                                <input id="my-input" class="form-control" type="date" name="date_to" required>
                                            </div>
                                        </div>
                                        <div class="col">  
                                            <input type="submit" name="filter_date" value="Filter" class="btn filter_date">
                                        </div>
                                    </div>
                                </form>

                                

                                

                                <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>
                                

                                <div class="card">
                                    
                                    <div class="card-body">
                                    <table class="display table-light table-responsive-lg" id="today_attendance">

<thead>
    <?php 
        if(!empty($date_filtered)){
            echo "<tr > <td colspan=11><a href='check_attendance.php' class='btn export_btn'>Back to todays attendance</a></td> </tr>";
            echo "<tr>";
            echo "<td colspan=11>";
                echo "<form method='post' action='export.php'>";
                echo "    <input type='text' name='date_from' value='$date_from' hidden> ";
                echo  "   <input type='text' name='date_to' value='$date_to' hidden>";
                echo  "   <input type='number' name='usid' value='$user_id' hidden>";
                echo "    <input type='submit' name='btn_export_filter' value='Export as CSV' class='btn mb-2 export_btn' >";
                echo "</form>";
                echo "<h3 class=title-page>". $date_filtered[0]['first_name'] ." " . $date_filtered[0]['last_name'] ." </h3>"; 
            echo "</td>";
        echo "</tr>";
        }
        
    ?>
    <tr>
        <th>Name</th>
        <th>Date</th>
        <th>IN</th>
        <th>OUT</th>
        <th>IN</th>
        <th>OUT</th>
        <th>IN</th>
        <th>OUT</th>
        <th>HOURS</th>
        <!-- <th>Time</th> -->
        
        <th class="text-center">Action</th>
    </tr>
</thead>
<tbody>

    <?php if(isset($date_filtered)): ?>

            <?php if(!empty($date_filtered)): ?>

                <!-- SET NAME -->
                
                <?php foreach($date_filtered as $user_record):?>
                    <tr>                 
                        <td><?= $user_record['first_name'] . " " . $user_record['last_name'] ?></td>
                        <td><?= $user_record['date'] ?></td>
                        <td><?= Attendance::change_hours_format( $user_record['first_time_in']  ) ?></td>
                        <td><?= Attendance::change_hours_format( $user_record['first_time_out']  ) ?></td>
                        <td><?= Attendance::change_hours_format( $user_record['second_time_in']  ) ?></td>
                        <td><?= Attendance::change_hours_format( $user_record['second_time_out'] )  ?></td>
                        <td><?= Attendance::change_hours_format( $user_record['third_time_in']  ) ?></td>
                        <td><?= Attendance::change_hours_format( $user_record['third_time_out']  ) ?></td>
                        <td><?= Attendance::calculate_total_hours($user_record, $user_record['position_id']) ?></td>
                        
                        <!-- <td><a href="" class="btn attendance_action_btn" title="report" title="Delete"> <i class="fas fa-trash"></i> </a></td> -->
                        <td>
                            <a href="edit_attendance.php?attId=<?= $user_record['id'] ?>&usId=<?=$user_record['user_id']?>" class="btn attendance_action_btn " title="Edit"> <i class="fas fa-pen"></i> </a>
                            <a href="#" att_id=<?=$user_record['id']?> usid=<?=$user_record['user_id']?> class="btn attendance_action_btn delete_attendance" title="Delete"> <i class="fas fas fa-trash"></i> </a>
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="text-center" colspan="4">NO DATA FOR SELECTED DATE</td>
                </tr>
            <?php endif; ?>

    <?php else: ?>
        <!-- <h1>TODAYS ATTENDANCE</h1> -->
    <?php foreach($todays_attendance as $attendance):?>
        <tr>
            
            <td><?= $attendance['first_name'] . " " . $attendance['last_name'] ?>  </td>
            <td> <?= $attendance['date'] ?> </td>
            <td><?= Attendance::change_hours_format( $attendance['first_time_in']  ) ?></td>
            <td><?= Attendance::change_hours_format( $attendance['first_time_out']  ) ?></td>
            <td><?= Attendance::change_hours_format( $attendance['second_time_in']  ) ?></td>
            <td><?= Attendance::change_hours_format( $attendance['second_time_out'] )  ?></td>
            <td><?= Attendance::change_hours_format( $attendance['third_time_out']  ) ?></td>
            <td><?= Attendance::change_hours_format( $attendance['third_time_out']  ) ?></td>
            <td><?= Attendance::calculate_total_hours($attendance) ?></td>

            
            <!-- <td><a href="" class="btn attendance_action_btn" title="report" title="Delete"> <i class="fas fa-trash"></i> </a></td> -->
            <td>
                <a href="edit_attendance.php?attId=<?= $attendance['id'] ?>&usId=<?=$attendance['user_id']?>" class="btn attendance_action_btn " title="Edit"> <i class="fas fa-pen"></i> </a>
                <a href="#" att_id=<?=$attendance['id']?> usid=<?=$attendance['user_id']?> class="btn attendance_action_btn delete_attendance" title="Delete"> <i class="fas fas fa-trash"></i> </a>
            </td>
            
        </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</tbody>
</table>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                        
                        
                    

                </div>
        
        <?php require_once 'delete_modal.php' ?>

        <?php require_once "includes/footer.php" ?>
        <script>
            $(document).ready(function () {

                $('#today_attendance').DataTable();
                $(".delete_attendance").click(function (e) { 
                    e.preventDefault();

                    var attendance_id = $(this).attr("att_id");
                    var user_id = $(this).attr("usid");

                    $(".modal-delete").modal('show');
                    $(".delete-message").text("Are you sure to delete this record?");

                    $('.delete-modal-btn').click(function (e) { 
                        $.ajax({
                        type: "POST",
                        url: "includes/attendance/delete_attendance.php",
                        data: {"attendance_id":attendance_id, "user_id": user_id},
                        success: function (response) {
                            if(!response.data){
                             location.reload(true);
                            }
                        }
                    });     
                        
                    });
                    
                    // if(confirm("Are you sure to report this user's attendance?")){
                        
                                           
                    // }

                });

                
            });
        </script>