<?php require_once "includes/header.php" ?>
<?php 
    $user_list_of_appeal = Appeal::get_current_user_list_of_appeal($user->id);
    
    
?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">My Profile</h1>
                    </div>
                                        

                        <div class="row p-3">
                            
                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>
                                
                            <div class="col-lg-12">

                                    
                                <div class="mb-2">
                                    <a href="user_add_appeal.php" class="btn add_appeal_btn">Apply appeal</a>
                                </div>
                                    
                                        
                                    

                                <div class="card">
                                    <div class="card-body">
                                        
                                    
                                        

                                            <table class="table table-responsive-lg table-hover display" id="appeal-table">
                                                <thead class="">
                                                    <tr>
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
                                                            foreach ($user_list_of_appeal as $appeal) {

                                                                if($appeal->status === "pending"){
                                                                    $status = " <span class='badge bg-primary text-white' > " . $appeal->status . " </span>";
                                                                }elseif($appeal->status === "approve"){
                                                                    $status = " <span class='badge bg-success text-white' > " . $appeal->status . " </span>";
                                                                }else{
                                                                    $status = " <span class='badge bg-danger text-white' > " . $appeal->status . " </span>";
                                                                }

                                                                echo "<tr>";
                                                                    echo "<td>" . $appeal->date . " </td>";
                                                                    echo "<td>" . $appeal->reason . " </td>";
                                                                    echo "<td>" . str_replace("_"," ", $appeal->time_status) . " </td>";
                                                                    echo "<td>" . $appeal->time . " </td>";
                                                                    echo "<td> <h5>" . $status . " </h5> </td>";
                                                                    echo "<td> <a href='#' class='btn  delete_appeal_btn' appId={$appeal->id}> DELETE </a></td>";
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
                
                <?php require_once 'delete_modal.php' ?>

        <?php require_once "includes/footer.php" ?>
        <script>
            $(document).ready(function () {

                $('#appeal-table').DataTable();

                $(".delete_appeal_btn").click(function (e) { 
                    e.preventDefault();
                    
                    let appId = $(this).attr("appId");

                    $(".modal-delete").modal('show');
                    $(".delete-message").text("Are you sure to delete Attendance appeal?");

                    $('.delete-modal-btn').click(function (e) { 
                        $.ajax({
                        type: "POST",
                        url: "user_delete_appeal.php",
                        data: {"appId": appId},
                        success: function (response) {
                            if(!response.data){
                             location.reload(true);
                            // alert(response);
                            }
                        }
                    }); 
                        
                    });
                });
            });

        </script>