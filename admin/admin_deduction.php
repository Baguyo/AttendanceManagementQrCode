<?php require_once "includes/header.php" ?>
<?php 

    if($user->user_role === 'user'){
        redirect('index.php');
    }

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['deduction_id'])){
            $deduction_id = validate_input($_POST['deduction_id']);
            
            $deduction_to_delete = Deduction::find_by_id($deduction_id);
            if($deduction_to_delete){
                $deduction_to_delete->delete();
            }else{
                return false;
            }
        }
    }

    $all_deduction = Deduction::find_all();
    
?>


                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Deduction List</h1>
                    </div>
                                        
                    
                        <div class="row">
                            
                            <div class="col-lg-12 p-3">

                                <a href="admin_add_deduction.php" class="btn add_deduction_btn mb-2">Add deduction</a>    
                                
                            <div>
                            <!-- <a href="add_user.php" class='btn add_user_btn mb-2'>Add user</a> -->

                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>


                            
                            </div>
        
                            <div class="card  ">
                              
                              <div class="card-body">
                              <table id="deduction_table" class="display hover table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    
                                        foreach ($all_deduction as $deduction) {
                                            echo "<tr dId={$deduction->id}>";
                                            echo "<td>" . $deduction->name . "</td>";
                                            echo "<td>" . $deduction->amount . "</td>";
                                            echo "<td> <span> 
                                                            

                                                        
                                                        <a href='admin_edit_deduction.php?dId={$deduction->id}' class='btn btn-dark'> <i class='fas fa-marker'></i> </a>
                                                    
                                                                
                                                        <button title='Delete' type='submit' class='btn btn-danger delete_btn' deductionId={$deduction->id} > <i class='fas fa-trash'></i> </button>                                                            
                                                            
                                                    </span> </td>";

                                            echo "</tr>";
                                            
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
        
            <?php require_once "delete_modal.php" ?>
                
        <?php require_once "includes/footer.php" ?>

        
        <script>
            $(document).ready( function () {
                $('#deduction_table').DataTable();

                $(".delete_btn").click(function (e) { 
                    e.preventDefault();

                    let deduction = $(this).attr('deductionId');

                    $(".modal-delete").modal('show');
                    $(".delete-message").text("Are you sure to delete this deduction?");

                    $('.delete-modal-btn').click(function (e) { 
                        $.ajax({
                        type: "POST",
                        url: "admin_deduction.php",
                        data: {"deduction_id":deduction},
                        success: function (response) {
                            if(!response.data){
                                $(".modal-delete").modal('hide');
                                $("tr[dId="+deduction +"]").fadeOut(500);
                             
                            }
                        }
                    });  

                    
                    
                });

                            

            } );
        });




        </script>