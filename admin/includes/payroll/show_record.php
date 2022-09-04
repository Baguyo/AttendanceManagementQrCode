<?php  require_once "../function.php" ?>
<?php  require_once "../../../common/classes/Database.php" ?>
<?php  require_once "../../../common/classes/DB_object.php" ?>
<?php  require_once "../../../common/classes/Attendance.php" ?>
<?php  require_once "../../../common/classes/Position.php" ?>






<?php 
    $output = "";
    // echo "asd";
    if(isset($_POST['usId']) && isset($_POST['date_from']) && isset($_POST['date_to'])){
        $user_id = validate_input($_POST['usId']);
        $date_from = validate_input($_POST['date_from']);
        $date_to = validate_input($_POST['date_to']);

        

         $user_attendace = Attendance::admin_fnc_filter_attendace($date_from, $date_to, $user_id);

        if( isset($user_attendace) ){

            if(!empty($user_attendace)){

                $output .= '  
                <div class="table-responsive">  
                     <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Total Hours</th>
                                </tr>
                            </thead>
                        '
                        
                     ;  
                     foreach($user_attendace as $user_record){
                     $output .= "   <tr> ";      
                            $output .= " <td> "  . $user_record['first_name'] . " " . $user_record['last_name'] ."</td>";
                            $output .= " <td> "  . $user_record['date'] . " </td>";

                            
                            

                            

                            // $output .= Attendance::if_has_appeal($user_record['first_time_in'], array_keys( $user_record, $user_record['first_time_in'] ));
                            // $output .= Attendance::if_has_appeal($user_record['first_time_out'], array_keys( $user_record, $user_record['first_time_out']));
                            // $output .= Attendance::if_has_appeal($user_record['second_time_in'], array_keys( $user_record, $user_record['second_time_in']));
                            // $output .= Attendance::if_has_appeal($user_record['second_time_out'], array_keys( $user_record, $user_record['second_time_out']));
                            // $output .= Attendance::if_has_appeal($user_record['third_time_in'], array_keys( $user_record, $user_record['third_time_in']));
                            // $output .= Attendance::if_has_appeal($user_record['third_time_out'], array_keys( $user_record, $user_record['third_time_out']));

                            $output .= Attendance::if_has_appeal($user_record);
                            

                            
                            $output .= " <td> "  . Attendance::calculate_total_hours($user_record, $user_record['position_id'])  . "</td>";
                            
                            
                            $output .= " <td><a 
                                                attId={$user_record['id']}
                                                usId={$user_record['user_id']}
                                                date={$user_record['date']}
                                                fI={$user_record['first_time_in']}
                                                fO={$user_record['first_time_out']}
                                                sI={$user_record['second_time_in']}
                                                sO={$user_record['second_time_out']}
                                                tI={$user_record['third_time_in']}
                                                tO={$user_record['third_time_out']}
                             class=' edit_record_btn btn attendance_action_btn ' title='Edit'> <i class='fas fa-pen'></i> </a></td>";
                            $output .= " <td><a href='#' att_id={$user_record['id']} usid={$user_record['user_id']} class='btn attendance_action_btn delete_attendance' title='Delete'> <i class='fas fas fa-trash'></i> </a></td>";
                    $output .= "</tr>";
                        
                    }
                    
                $output .= ' 
                     </table>  
                </div>  
                ';  
                echo $output;  

            }

        }


    }else{
        die();

    }

?>




<!-- EDIT RECORD MODAL -->
<!-- <div class="modal fade edit_record_modal" id="" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee attendance</h5>
                    <button  type="button" class="close_edit_record_modal btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-x"></i> </button>
            </div>
            <div class="modal-body">

                <div class="alert alert-success" role="alert">
                    <strong>NOTE! Time attendance are in 24 hours format  </strong>
                </div>
                

                <form action="" class="edit_record_form" method="post">

                <div class="mb-3">
                      <label for="" class="form-label">Date</label>
                      <input type="text"
                        class="form-control date" name="date" id="" aria-describedby="helpId" placeholder="" readonly>
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">First time in</label>
                      <input type="text"
                        class="form-control fI" name="fI" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">First time out</label>
                      <input type="text"
                        class="form-control fO" name="fO" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Second time in</label>
                      <input type="text"
                        class="form-control sI" name="sI" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Second time out</label>
                      <input type="text"
                        class="form-control sO" name="sO" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Third time in</label>
                      <input type="text"
                        class="form-control tI" name="tI" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Third time out</label>
                      <input type="text"
                        class="form-control tO" name="tO" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <input type="submit" value="Submit" class="btn btn-success">

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_edit_record_modal" data-bs-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div> -->


<!-- APPEAL ACTION MODAL -->
<!-- Button trigger modal -->

<div class="modal fade appeal_record_modal" id="" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">APPEAL RECORD</h5>
                <button  type="button" class="close_appeal_record_modal btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-x"></i> </button>
            </div>
            <div class="modal-body appeal_record_container">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_appeal_record_modal" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade edit_record_modal" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Employee attendance</h5>
        <button  type="button" class="close_edit_record_modal btn" aria-label="Close"><i class="fas fa-x"></i> </button>
      </div>
      <div class="modal-body">
      <div class="alert alert-success" role="alert">
                    <strong>NOTE! Time attendance are in 24 hours format  </strong>
                </div>
                

                <form action="" class="edit_record_form" method="post">

                <div class="mb-3">
                      <label for="" class="form-label">Date</label>
                      <input type="text"
                        class="form-control date" name="date" id="" aria-describedby="helpId" placeholder="" readonly>
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">First time in</label>
                      <input type="text"
                        class="form-control fI" name="fI" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">First time out</label>
                      <input type="text"
                        class="form-control fO" name="fO" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Second time in</label>
                      <input type="text"
                        class="form-control sI" name="sI" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Second time out</label>
                      <input type="text"
                        class="form-control sO" name="sO" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Third time in</label>
                      <input type="text"
                        class="form-control tI" name="tI" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Third time out</label>
                      <input type="text"
                        class="form-control tO" name="tO" id="" aria-describedby="helpId" placeholder="">
                      
                    </div>

                    <input type="submit" value="Submit" class="btn btn-success">

                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close_edit_record_modal" >Close</button>
        <!-- <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>


<!-- DELETE MODAL -->
<?php require_once '../../delete_modal.php' ?>

<script>

    $(".appeal_btn").click(function (e) { 
        var appeal_date = $(this).attr('date');
        var appeal_status = $(this).attr('status');
        var appeal_usId = $(this).attr('usId');

        $.ajax({
            type: "POST",
            url: "includes/payroll/show_appeal.php",
            data: {'appeal_date': appeal_date, 'appeal_status': appeal_status, "appeal_usId": appeal_usId},
            success: function (response) {
                $('.appeal_record_modal').modal("show");
                $('.appeal_record_container').html(response);
            }
        }); 
    });

        $(".close_appeal_record_modal").click(function (e) { 
            $('.appeal_record_modal').modal("hide");
       });


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


    $(".edit_record_btn").click(function (e) { 
        e.preventDefault();
        let attId =  $(this).attr('attId');
        let fI = $(this).attr('fI');
        let fO = $(this).attr('fO');
        let sI = $(this).attr('sI');
        let sO = $(this).attr('sO');
        let tI = $(this).attr('tI');
        let tO = $(this).attr('tO');
    //    alert($(this).attr('usId'));

    

       $(".edit_record_modal").modal('show');
        
            $(".date").val($(this).attr('date'));
            $(".fI").val(  $(this).attr('fI'));
            $(".fO").val(  $(this).attr('fO'));
            $(".sI").val(  $(this).attr('sI'));
            $(".sO").val(  $(this).attr('sO'));
            $(".tI").val(  $(this).attr('tI'));
            $(".tO").val(  $(this).attr('tO'));
            // console.log($(".edit_record_modal").children("input[class='date']").val());
            
        
            
       
       $(".close_edit_record_modal").click(function (e) { 
            $(".edit_record_modal").modal('hide');
            attId = null;
            // $(".fI").val(" ");
            // $(".fO").val(" ");
            // $(".sI").val(" ");
            // $(".sO").val(" ");
            // $(".tI").val(" ");
            // $(".tO").val(" ");
       });
       
       

       $(`.edit_record_form`).submit(function (e) { 
        e.preventDefault();
        

        

        $.ajax({
            type: "POST",
            url: "includes/payroll/save_edit_attendance_modal.php",
            data: { 
                'attId': attId, 
                'fI': $(".fI").val(),
                'fO': $(".fO").val(),
                'sI': $(".sI").val(),
                'sO': $(".sO").val(),
                'tI': $(".tI").val(),
                'tO': $(".tO").val(),
             },
            
            success: function (response) {
                
                window.location.reload(1);
                
                
                
            }
            
        });
       });


        
    });
</script>
