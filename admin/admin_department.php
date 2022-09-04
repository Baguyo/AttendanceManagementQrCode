<?php require_once "includes/header.php" ?>
<?php 

    if($user->user_role === 'user'){
        redirect('index.php');
    }

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['department_id'])){
            $department_id = validate_input($_POST['department_id']);
            
            $department_to_delete = Department::find_by_id($department_id);
            if($department_to_delete){
                $department_to_delete->delete();
            }else{
                return false;
            }
        }
    }

    $all_department = Department::find_all();
    
?>


                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Department List</h1>
                    </div>
                                        
                    
                        <div class="row">
                            
                            <div class="col-lg-12 p-3">

                                <a href="admin_add_department.php" class="btn add_deduction_btn mb-2">Add Department</a>    
                                
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
                                        
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    
                                        foreach ($all_department as $department) {
                                            
                                        echo "<tr dId={$department->id}>";
                                            echo "<td>" . $department->name . "</td>";
                                            
                                            echo "<td> <span> 
                                                            

                                                        
                                                        <a href='admin_edit_department.php?dId={$department->id}' class='btn btn-dark'> <i class='fas fa-marker'></i> </a>
                                                    
                                                                
                                                        <button title='Delete' type='submit' class='btn btn-danger delete_btn' departmentId={$department->id} > <i class='fas fa-trash'></i> </button>                                                            
                                                            
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
        
            <?php require_once "delete_modal.php" ?>
                
        <?php require_once "includes/footer.php" ?>

        
        <script>
            $(document).ready( function () {
                $('#deduction_table').DataTable();

                $(".delete_btn").click(function (e) { 
                    e.preventDefault();

                    let department = $(this).attr('departmentId');
                    

                    $(".modal-delete").modal('show');
                    $(".delete-message").text("Are you sure to delete this department?");

                    $('.delete-modal-btn').click(function (e) { 
                        $.ajax({
                        type: "POST",
                        url: "admin_department.php",
                        data: {"department_id":department},
                        success: function (response) {
                            if(!response.data){
                                $(".modal-delete").modal('hide');
                                $("tr[dId="+department +"]").fadeOut(500);
                             
                            }
                        }
                    });  

                    
                    
                });

                            

            } );
        });




        </script>