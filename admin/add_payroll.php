<?php require_once "includes/header.php" ?>
<?php 

    

      if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET['filter_date'])){
            $position_id = validate_input($_GET['position_id']);
            $date_from =  validate_input($_GET['date_from']);
            $date_to =  validate_input($_GET['date_to']);
            $position_selected = Position::find_by_id($position_id);
            // $date_filtered = Attendance::admin_fnc_filter_attendace($date_from, $date_to, $user_id);

           
            $employee_per_position = Attendance::calculate_user_salary($position_id, $date_from, $date_to);
        }
    }



     

?>


                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Add payroll</h1>
                    </div>
                    
                    
                    
                        <div class="row">

                            

                            <div class="col-lg-12 p-3">

                            <div class="card">
                                
                                <div class="card-body">
                                <form action="" method="GET" enctype="multipart/form-data">
                                    <div class="form-row">


                                    

                                        <div class="col">
                                            <div class="form-group">
                                                <select id="my-select" class="form-control" name="position_id" required>
                                                    <option value="">--SELECT--</option>
                                                    <?php 
                                                        
                                                        $all_position = Position::find_all();
                                                        foreach($all_position as $position){
                                                            echo "<option value=$position->id> $position->position_name </option>";
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

                                </div>
                            </div>                            

                            
                                

                                

                                
                                

                                
                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message mt-2'> {$session->message} </p>" ?>
                               <div class="card mt-2">
                                
                                <div class="card-body">
                                    <h1><?= isset($position_selected) ? $position_selected->position_name : "" ?></h1>
                                    <table class="display table-responsive-lg mt-4" id="salary_table">

                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date from</th>
                                                <th>Date to</th>
                                                <th>Total regular hours</th>
                                                <th>Total overtime hours</th>
                                                <th>Total payment</th>
                                                <!-- <th>Time</th> -->
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            
                                            <?php if(!empty($employee_per_position)): ?>
                                                
                                                <?php foreach ($employee_per_position as $user_id => $value):?>
                                                    <?php $user_account_payroll = User::find_by_id($user_id) ?>
                                                    <tr>

                                                        <td> <?= $user_account_payroll->first_name . " " . $user_account_payroll->last_name ?> </td>
                                                        <td class="show_record_modal text-primary" usId="<?= $user_id ?>" date_to="<?= $date_to ?>" date_from="<?= $date_from ?>" > <?= $date_from?> </td>
                                                        <td class="show_record_modal text-primary" usId="<?= $user_id ?>" date_to="<?= $date_to ?>" date_from="<?= $date_from ?>" > <?= $date_to?> </td>
                                                        <td> <?= $value['total_regular_hours']?> </td>
                                                        <td> <?= $value['total_overtime_hours']?> </td>
                                                        <td> <?= $value['total_salary']?> </td>
                                                        
                                                        <td class="text-center">

                                                        

                                                            <span class="action">

                                                                <button 
                                                                    class="btn btn-primary action_btn" 
                                                                    title="print"
                                                                    us_ttl_sly=<?= $value['total_salary']?>
                                                                    dt_to=<?= $date_to ?>
                                                                    dt_frm=<?= $date_from ?>
                                                                    usId=<?= $user_account_payroll->id ?>
                                                                >
                                                                    <!-- <i class="fas fa-sd-card"></i> -->
                                                                    Print
                                                                </button>

                                                                <button 
                                                                    class="btn btn-success action_btn"  
                                                                    title="save"
                                                                    us_ttl_sly=<?= $value['total_salary']?>
                                                                    dt_to=<?= $date_to ?>
                                                                    dt_frm=<?= $date_from ?>
                                                                    usId=<?= $user_account_payroll->id ?>
                                                                >
                                                                    Save
                                                                </button>

                                                                <button 
                                                                    class="btn btn-dark text-white mt-2 action_btn"  
                                                                    title="print_and_save"
                                                                    us_ttl_sly=<?= $value['total_salary']?>
                                                                    dt_to=<?= $date_to ?>
                                                                    dt_frm=<?= $date_from ?>
                                                                    usId=<?= $user_account_payroll->id ?>
                                                                >
                                                                    Print and Save
                                                                </button>
                                                </span>
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
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
  Launch static backdrop modal
</button> -->

<!-- Modal -->
<div class="modal fade show-attendance-modal " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Employee record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body show-attendance">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
                        
                    

                </div>

            
        
        

        <?php require_once "includes/footer.php" ?>
        <script>
            $(document).ready(function () {

                $(".action_btn").click(function (e) { 
                    var action = $(this).attr('title');
                    var user_salary = $(this).attr('us_ttl_sly');
                    var date_from = $(this).attr('dt_frm');
                    var date_to = $(this).attr('dt_to')
                    var usId = $(this).attr('usId');

                    
                    if(action === "print"){
                        window.open(`salary_slip.php?user_salary=${user_salary}&date_from=${date_from}&date_to=${date_to}&usId=${usId}`,
                                    "msgwindow",
                                     "width=500,height=500");
                    }else if(action === "save"){
                        $.ajax({
                            type: "POST",
                            url: "includes/payroll/action_salary.php",
                            data: { "user_salary": user_salary, "date_from": date_from, "date_to": date_to, "usId": usId, "action": action },
                            success: function (response) {
                                window.location.reload(1);
                            }
                        });
                    }else if(action === "print_and_save"){

                        $.ajax({
                            type: "POST",
                            url: "includes/payroll/action_salary.php",
                            data: { "user_salary": user_salary, "date_from": date_from, "date_to": date_to, "usId": usId, "action": action },
                            success: function (response) {
                                if(response === "save"){
                                    window.open(`salary_slip.php?user_salary=${user_salary}&date_from=${date_from}&date_to=${date_to}&usId=${usId}`,
                                    "msgwindow",
                                     "width=500,height=500");
                                     window.location.reload(1);
                                    
                                }
                            }
                        });

                    }

                    
                    
                });

                $('#salary_table').DataTable();

                $(".show_record_modal").click(function (e) { 
                    let usId = $(this).attr('usId');
                    let date_from = $(this).attr('date_from')
                    let date_to = $(this).attr('date_to')

                    // alert(usId + " " + date_from + " " + date_to);

                    $.ajax({
                        type: "POST",
                        url: "includes/payroll/show_record.php",
                        data: { 'usId':usId, 'date_from': date_from, 'date_to':date_to },
                        success: function (response) {
                            $('.show-attendance-modal').modal("show");
                                $('.show-attendance').html(response);

                            

                        }   
                    });

                    
                    
                });
                

                

                
                
                
            });
        </script>