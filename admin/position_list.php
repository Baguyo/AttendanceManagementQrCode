<?php require_once "includes/header.php" ?>
<?php

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['positionId'])){
            $positionId = validate_input($_POST['positionId']);
            
            $position_to_delete = Position::find_by_id($positionId);
            if($position_to_delete){
                $position_to_delete->delete();
            }else{
                return false;
            }
        }
    }

    $all_position = Position::find_all_joint_table();
    $all_position->bind_result($position_id, $position_name, $position_rate_per_hour, $position_rate_per_overtime, $time_start, $time_end, $department);

?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Position list</h1>
                    </div>
                                        

                        <div class="row">
                            <div class="col-lg-12 p-3">
                                
                            <div>
                            <a href="add_position.php" class='btn add_user_btn mb-2'>Add Position</a>



                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>

                            <div class="card">
                                
                                <div class="card-body">
                                <table class="display hover table-responsive-lg " id='position_table'>
                                    
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Name</th>
                                            <th>Rate Per hour</th>
                                            <th>Overtime Rate per hour</th>
                                            <th>Time start</th>
                                            <th>Time end</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                            
                                            
                                            <?php while($all_position->fetch()): ?>

                                                <tr pId=<?= $position_id ?>>
                                                    <td> <?= $department; ?> </td>
                                                    <td> <?= $position_name ?> </td>
                                                    <td> <?= $position_rate_per_hour ?> </td>
                                                    <td> <?= $position_rate_per_overtime ?> </td>
                                                    <td><?= $time_start ?></td>
                                                    <td><?= $time_end ?></td>
                                                    <td> <div> 
                                                        <a href='edit_position.php?pId=<?=$position_id?>' class='btn btn-dark'> <i class='fas fa-marker'></i> </a>
                                                        
                                                        <button title='Delete' type='submit' class='btn btn-danger delete_btn' positionId=<?= $position_id ?> > <i class='fas fa-trash'></i> </button>                                                            

                                                            
                                            </div> </td>
                                                </tr>

                                            <?php endwhile; ?>

                                        
                                        
                                    </tbody>
                                </table>    
                                </div>
                            </div>
                        </div>
                    

                </div>

                <?php require_once "delete_modal.php" ?>
                
        <?php require_once "includes/footer.php" ?>
        <script>
            $(document).ready(function () {

                $('#position_table').DataTable();

                $(".delete_btn").click(function (e) { 
                    e.preventDefault();

                    let positionId = $(this).attr('positionId');

                    $(".modal-delete").modal('show');
                    $(".delete-message").text("Are you sure to delete this position?");

                    $('.delete-modal-btn').click(function (e) { 
                        $.ajax({
                        type: "POST",
                        url: "position_list.php",
                        data: {"positionId":positionId},
                        success: function (response) {
                            if(!response.data){
                                $(".modal-delete").modal('hide');
                                // $('#position_table').load('position_list.php #position_table');
                                $("tr[pId="+positionId +"]").fadeOut(500);
                             
                            }
                        }
                    });  

                    
                    
                });
            });
            });
        </script>