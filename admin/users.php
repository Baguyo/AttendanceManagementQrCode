<?php require_once "includes/header.php" ?>
<?php 



    if(isset($_GET['image'])){
        $file = $_GET['image'];
        if(file_exists($file)){
            User::download_qr_code($file);
            // redirect('users.php');
        }
    }


    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['user_id'])){
            $user_id = validate_input($_POST['user_id']);
            
            $user_to_delete = User::find_by_id($user_id);
            if($user_to_delete){
                $user_to_delete->delete();
            }else{
                return false;
            }
        }
    }


?>
<?php 
$all_users = User::find_all();
$all_position = Position::find_all();
?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Users</h1>
                    </div>
                                        

                        <div class="row">
                            <div class="col-lg-12 p-3">
                                
                            <div>
                            <a href="add_user.php" class='btn add_user_btn mb-2'>Add user</a>



                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>

                            <div class="card">
                                
                                <div class="card-body">
                                <table class="display hover table-responsive-lg " id='users_table'>
                                    
                                    <thead>
                                        <tr>
                                            <th>Name</th>   
                                            <th>Role</th>
                                            <th>Position</th>
                                            <th>Image</th>
                                            <th>QR code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                            <?php foreach($all_users as $users): ?>
                                                
                                                <tr sId=<?= $users->id ?>>
                                                    <td> <?= $users->first_name . " " . $users->last_name ?>
                                                        <div class="user_actions">
                                                            <a href="#" class=" delete-btn text-danger delete_user" usId=<?= $users->id ?>>Delete</a>
                                                            <a href="edit_user.php?usid=<?=$users->id?>" class="">Edit</a>
                                                        </div>
                                                    </td>

                                                    <td> <?= $users->user_role ?> </td>

                                                    <td> 
                                                        <?php 

                                                            if(!$users->position_id){
                                                                echo "No Position";
                                                            }else{
                                                                    foreach($all_position as $position){
                                                                        if($position->id === $users->position_id){
                                                                            echo $position->position_name;
                                                                        }               
                                                                    }
                                                            }
                                                        ?> 
                                                    </td>

                                                    
                                                    <td> <img class='img-responsive'  height="150px" src="<?=$users->display_user_photo()?>" alt=""> </td>
                                                    <td>
                                                         <img class='img-responsive'  height="150px" width="" src="<?=$users->display_user_qr_code()?>" alt="">
                                                         <div>
                                                            <a href="users.php?image=<?php echo $users->display_user_qr_code() ?>" >Download</a>
                                                         </div>
                                                     </td>
                                                    
                                                </tr>
                                                
                                            <?php endforeach; ?>
                                        
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

                $('#users_table').DataTable();

                
                $(".delete-btn").click(function (e) { 
                    e.preventDefault();

                    let user_id = $(this).attr('usId');

                    
                    $(".modal-delete").modal('show');
                    $(".delete-message").text("Are you sure to delete this user?");

                    $('.delete-modal-btn').click(function (e) { 
                        $.ajax({
                        type: "POST",
                        url: "users.php",
                        data: {"user_id":user_id},
                        success: function (response) {
                            if(!response.data){
                                $(".modal-delete").modal('hide');
                                $("tr[sId="+user_id+"]").fadeOut(500);
                             
                            }
                        }
                    });  

                    })
                    
                });
            });
        </script>