<?php require_once "includes/header.php" ?>
<?php 

    

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['salary_id'])){
            $salary_id = validate_input($_POST['salary_id']);
            
            $salary_to_delete = Salary::find_by_id($salary_id);
            if($salary_to_delete){
                $salary_to_delete->delete();
            }else{
                return false;
            }
        }
    }

    $all_salary = Salary::find_all();
    (!$all_salary) ? $all_salary=[] :"";
?>


                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Payroll List</h1>
                    </div>
                                        
                    
                        <div class="row">
                            
                            <div class="col-lg-12 p-3">

                                <a href="add_payroll.php" class="btn add_salary_btn mb-2">Add payroll</a>    
                                
                            <div>
                            <!-- <a href="add_user.php" class='btn add_user_btn mb-2'>Add user</a> -->

                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>


                            
                            </div>
        
                            <div class="card  ">
                              
                              <div class="card-body">
                              <table id="salary_table" class="display hover table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Date from</th>
                                        <th>Date to</th>
                                        <th>Net pay</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($all_salary as $salary) {
                                            echo "<tr dId={$salary->id}>";

                                            $user_salary = User::find_by_id($salary->user_id);
                                            echo "<td>" . $user_salary->first_name . " " . $user_salary->last_name . "</td>";
                                            echo "<td>" . $salary->position . "</td>";
                                            echo "<td>" . $salary->date_from . "</td>";
                                            echo "<td>" . $salary->date_to . "</td>";
                                            
                                            echo "<td>" . $salary->total_salary . "</td>";
                                            echo "<td> <span> 
                                                            

                                                        
                                                        
                                                        <button class='btn btn-primary print_salary' 
                                                        dt_to={$salary->date_to} 
                                                        dt_frm={$salary->date_from} 
                                                        usId={$user_salary->id}
                                                        us_ttl_sly={$salary->total_salary}
                                                         '>
                                                        <i class='fas fa-print'></i>
                                                        </button>
                                                        
                                                        <button title='Delete' type='submit' class='btn btn-danger delete_btn' salaryId={$salary->id} > <i class='fas fa-trash'></i> </button>                                                            
                                                            
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
                $('#salary_table').DataTable();

                $(".print_salary").click(function (e) { 
                    var user_salary = $(this).attr('us_ttl_sly');
                    var date_from = $(this).attr('dt_frm');
                    var date_to = $(this).attr('dt_to')
                    var usId = $(this).attr('usId');

                    window.open(`salary_slip.php?user_salary=${user_salary}&date_from=${date_from}&date_to=${date_to}&usId=${usId}`,
                                    "msgwindow",
                                     "width=500,height=500");
                    
                });

                $(".delete_btn").click(function (e) { 
                    e.preventDefault();

                    let salary = $(this).attr('salaryId');

                    $(".modal-delete").modal('show');
                    $(".delete-message").text("Are you sure to delete this salary?");

                    $('.delete-modal-btn').click(function (e) { 
                        $.ajax({
                        type: "POST",
                        url: "payroll.php",
                        data: {"salary_id":salary},
                        success: function (response) {
                            if(!response.data){
                                $(".modal-delete").modal('hide');
                                $("tr[dId="+salary +"]").fadeOut(500);
                             
                            }
                        }
                    });  

                    
                    
                });

                            

            } );
        });




        </script>