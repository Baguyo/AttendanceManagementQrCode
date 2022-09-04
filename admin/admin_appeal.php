<?php require_once "includes/header.php" ?>
<?php 

    

    


    //FETCH ALL APPEAL RECORD
    $all_appeal = Appeal::joint_table_find_all();
    $all_appeal->bind_result($appeal_id, $appeal_date, $appeal_reason, $appeal_time_status, $appeal_time, $appeal_status, $first_name, $last_name );
?>


                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Attendance appeal</h1>
                    </div>
                                        

                        <div class="row">
                            <div class="col-lg-12 p-3">
                                
                            <div>
                            <!-- <a href="add_user.php" class='btn add_user_btn mb-2'>Add user</a> -->

                            


                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>
                            </div>
        
                            <div class="card  ">
                              
                              <div class="card-body">
                              <table id="appeal_table" class="display hover table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Time status</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                            
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        while($all_appeal->fetch()){
                                            echo "<tr>";
                                                echo "<td>" . $first_name . " " . $last_name . "</td>";
                                                echo "<td>" . $appeal_date . "</td>";
                                                echo "<td>" . $appeal_reason . "</td>";
                                                echo "<td>" . str_replace("_", " ", $appeal_time_status) . "</td>";
                                                echo "<td>" . $appeal_time . "</td>";

                                                if($appeal_status === "pending"){
                                                    echo "<td appStatus={$appeal_id}> <div class='badge bg-primary text-white p-2' >  $appeal_status </div> </td>";
                                                    
                                                }elseif($appeal_status === "approve"){
                                                    echo "<td appStatus={$appeal_id}> <div class='badge bg-success text-white p-2'  >  $appeal_status </div> </td>";
                                                }elseif($appeal_status === "denied"){
                                                    echo "<td appStatus={$appeal_id}> <div class='badge bg-danger text-white p-2'  >  $appeal_status </div> </td>";
                                                }

                                                echo "<td> <span> 
                                                            

                                                                <button title='Denied' type='submit' class='btn btn-dark denied_btn' appId={$appeal_id} > <i class='fas fa-exclamation'></i> </button>
                                                                
                                                                <button title='Approve' type='submit' class='btn btn-success approve_btn' appId={$appeal_id} > <i class='fas fa-thumbs-up'></i> </button>                                                            
                                                            
                                                    </span> </td>";

                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>

                              </div>
                            </div>


                              
                            </div>
                        </div>
                    

                </div>
                
        <?php require_once "includes/footer.php" ?>
        <script>
            $(document).ready( function () {
                $('#appeal_table').DataTable();

                $(".approve_btn").click(function (e) { 
                    e.preventDefault();

                    let appId = $(this).attr('appId');

                    $.ajax({
                        type: "POST",
                        url: "includes/appeal/admin_action_appeal.php",
                        data: {'appId_approve':appId},
                        success: function (response) {
                            if(!response.data){
                                $("td[appStatus="+appId+"]").html(response);
                            }
                        }
                    });
                    
                });

                $(".denied_btn").click(function (e) { 
                    e.preventDefault();

                    let appId = $(this).attr('appId');

                    // alert(appId);

                    $.ajax({
                        type: "POST",
                        url: "includes/appeal/admin_action_appeal.php",
                        data: {'appId_denied':appId},
                        success: function (response) {
                            if(!response.data){
                                $("td[appStatus="+appId+"]").html(response);
                            }
                        }
                    });
                    
                });

            } );




        </script>