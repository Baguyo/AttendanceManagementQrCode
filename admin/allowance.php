<?php require_once "includes/header.php" ?>
<?php 

    

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['allowance_id'])){
            $allowance_id = validate_input($_POST['allowance_id']);
            
            $allowance_to_delete = Allowance::find_by_id($allowance_id);
            if($allowance_to_delete){
                $allowance_to_delete->delete();
            }else{
                return false;
            }
        }
    }

    $all_allowance = Allowance::find_all();
    (!$all_allowance) ? $all_allowance=[] :"";
?>


                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Allowance List</h1>
                    </div>
                                        
                    
                        <div class="row">
                            
                            <div class="col-lg-12 p-3">

                                <a href="add_allowance.php" class="btn add_allowance_btn mb-2">Add Allowance</a>    
                                
                            <div>
                            <!-- <a href="add_user.php" class='btn add_user_btn mb-2'>Add user</a> -->

                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>


                            
                            </div>
        
                            <div class="card  ">
                              
                              <div class="card-body">
                              <table id="allowance_table" class="display hover table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($all_allowance as $allowance) {
                                            echo "<tr dId={$allowance->id}>";
                                            echo "<td>" . $allowance->name . "</td>";
                                            echo "<td>" . $allowance->amount . "</td>";
                                            echo "<td> <span> 
                                                            

                                                        
                                                        <a href='edit_allowance.php?aId={$allowance->id}' class='btn btn-dark'> <i class='fas fa-marker'></i> </a>
                                                    
                                                                
                                                        <button title='Delete' type='submit' class='btn btn-danger delete_btn' allowanceId={$allowance->id} > <i class='fas fa-trash'></i> </button>                                                            
                                                            
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
                $('#allowance_table').DataTable();

                $(".delete_btn").click(function (e) { 
                    e.preventDefault();

                    let allowance = $(this).attr('allowanceId');

                    $(".modal-delete").modal('show');
                    $(".delete-message").text("Are you sure to delete this allowance?");

                    $('.delete-modal-btn').click(function (e) { 
                        $.ajax({
                        type: "POST",
                        url: "allowance.php",
                        data: {"allowance_id":allowance},
                        success: function (response) {
                            if(!response.data){
                                $(".modal-delete").modal('hide');
                                $("tr[dId="+allowance +"]").fadeOut(500);
                             
                            }
                        }
                    });  

                    
                    
                });

                            

            } );
        });




        </script>