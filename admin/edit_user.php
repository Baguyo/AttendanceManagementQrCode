<?php require_once "includes/header.php" ?>
<?php 
    
    if($user->user_role === 'user'){
        redirect('index.php');
    }
    
    if(isset($_GET['usid'])){
        $user_id_edit = validate_input($_GET['usid']);
        $user_to_edit = User::find_by_id($user_id_edit);
        
        $all_deduction = Deduction::find_all();    
    }else{
        die();
    }

    
    
    
    
    

    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        


        
        if(isset($_POST['update_user'])){
            

            $username = validate_input($_POST['username']);
            $password = validate_input($_POST['new_password']);
            $first_name = validate_input($_POST['first_name']);
            $last_name = validate_input($_POST['last_name']);
            $user_role = validate_input($_POST['user_role']);
            $position = validate_input($_POST['position']);

            
            $user_to_edit->first_name = $first_name;
            $user_to_edit->last_name = $last_name;
            $user_to_edit->username = $username;
            $user_to_edit->user_role = $user_role;
            $user_to_edit->position_id = $position;

            if(!empty($_POST['new_password'])){
                $user_to_edit->password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>11));;
            }

            if($user_to_edit->set_file($_FILES['user_image'])){
                $user_to_edit->save_user_image();
                $session->message($user_to_edit->first_name . " " . $user_to_edit->last_name . " Successfully updated");
                $user_to_edit->save();
                redirect("users.php");
            
            }else{
                $session->message($user_to_edit->first_name . " " . $user_to_edit->last_name . " Successfully updated");
                $user_to_edit->save();
                redirect("users.php");
            }

        }
    }
    
    $all_position = Position::find_all();
    $user_not_selected_deduction = Deduction::get_user_not_selected_deduction($user_to_edit);
    $user_not_selected_allowance = Allowance::get_user_not_selected_allowance($user_to_edit);

    $user_deductions = Deduction::show_user_deduction($user_to_edit);
    $user_deductions->bind_result($user_deduction_id, $deduction_id, $deduction_amount, $deduction_name);

    
    
    
    // foreach ($user_not_seleted_deduction as $not_selected_deduction) {
    //     echo $not_selected_deduction->amount;
    // } 

    

?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">User Profile</h1>
                    </div>
                                        

                        
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="card">
                                        
                                        <div class="card-body">
                                        
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <form action="" method="POST" enctype="multipart/form-data">

                                                        <?php 
                                                            if(!empty($user_to_edit->error)){
                                                                echo $file_error = join("<br>", $user_to_edit->error);
                                                            }
                                                        ?>

                                                    <div class="form-group">
                                                        <label for="">Image</label>
                                                        <input  class="form-control-file" type="file" name="user_image">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">First name</label>
                                                        <input  class="form-control" type="text" name="first_name" value="<?php echo $user_to_edit->first_name; ?>" >
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Last name</label>
                                                        <input  class="form-control" type="text" name="last_name" value="<?=$user_to_edit->last_name?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Username</label>
                                                        <input class="form-control" type="text" name="username" value="<?=$user_to_edit->username?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">New password</label>
                                                        <input  class="form-control" type="password" name="new_password">
                                                    </div>

                                                    <div class="mb-3">
                                                      <label for="" class="form-label">Position</label>
                                                      <select class="form-control" name="position" id="">
                                                            <?php if(!$user_to_edit->position_id): ?>
                                                                <option value="" selected >--SELECT--</option>
                                                            <?php endif; ?>

                                                        <?php foreach($all_position as $position): ?>
                                                            
                                                            

                                                            <?php if($position->id == $user_to_edit->position_id): ?>
                                                                <option value="<?= $position->id ?>" selected ><?= $position->position_name ?></option>
                                                            <?php else: ?>
                                                                <option value="<?= $position->id ?>"><?= $position->position_name ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                      </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="my-select">Role</label>
                                                        <select id="my-select" class="form-control" name="user_role">
                                                            <option value="user" <?= ($user_to_edit->user_role == "user") ? "selected" : "" ?>>User</option>
                                                            <option value="admin" <?= ($user_to_edit->user_role == "admin") ? "selected" : "" ?>>Admin</option>
                                                        </select>
                                                    </div>


                                                    <input type="submit" name='update_user' value="Update profile" class="btn update_user_btn">

                                                    </form>
                                                </div>

                                                <div class="col-lg-4 ">
                                                    
                                                    <div class="card bg-light" >
                                                        <div class="card-body">
                                                        
                                                        <h4 class="primary-color">Deduction</h4>
                                                        <hr>
                                                        <ul class="list-group" id="deduction">
                                                            
                                                            <?php 
                                                            
                                                                while($user_deductions->fetch()){
                                                                    echo "<li class='list-group-item'> &#8369;{$deduction_amount}  {$deduction_name} 
                                                                     <span class='' style='float:right'> <button dId={$user_deduction_id}  title='Delete user deduction' class='btn btn-danger btn_delete_deduction'>
                                                                      <i class='fas fa-trash'></i> </button> </span> </li>";
                                                                }
                                                                foreach ($user_not_selected_deduction as $not_selected_deduction ) {
                                                                    echo "<li class='list-group-item'> &#8369;{$not_selected_deduction->amount}  {$not_selected_deduction->name}  
                                                                    <span class='' style='float:right'> 
                                                                    <button dId={$not_selected_deduction->id} title='Add deduction' class='btn btn-success btn_add_deduction'>
                                                                     <i class='fas fa-plus'></i> </button> </span> </li>";
                                                                }
                                                                

                                                            ?>
                                                        
                                                            
                                                            
                                                        </ul>
                                                    
                                                        </div>
                                                    </div>

                                                    <div class="card bg-light mt-4" >
                                                        <div class="card-body">
                                                        
                                                        <h4 class="primary-color">Allowance</h4>
                                                        <hr>
                                                        <ul class="list-group" id="allowance">
                                                            
                                                            <?php 
                                                            $user_allowance = Allowance::show_user_allowance($user_to_edit);
                                                            $user_allowance->bind_result($user_allowance_id, $allowance_id, $allowance_amount, $allowance_name);
                                                            
                                                                while($user_allowance->fetch()){
                                                                    echo "<li class='list-group-item'> &#8369;{$allowance_amount}  {$allowance_name} 
                                                                     <span class='' style='float:right'> <button aId={$user_allowance_id}  title='Delete user allowance' class='btn btn-danger btn_delete_allowance'>
                                                                      <i class='fas fa-trash'></i> </button> </span> </li>";
                                                                }
                                                                foreach ($user_not_selected_allowance as $not_selected_allowance ) {
                                                                    echo "<li class='list-group-item'> &#8369;{$not_selected_allowance->amount}  {$not_selected_allowance->name}  
                                                                    <span class='' style='float:right'> 
                                                                    <button aId={$not_selected_allowance->id} title='Add allowance' class='btn btn-success btn_add_allowance'>
                                                                     <i class='fas fa-plus'></i> </button> </span> </li>";
                                                                }
                                                                

                                                            ?>
                                                        
                                                            
                                                            
                                                        </ul>
                                                    
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                                



                                
                        </div>
                    

                </div>
                
        <?php require_once "includes/footer.php" ?>
        <script>
            $(document).ready(function () {
                

                //DEDUCTION ACTION
                $(".btn_add_deduction").click(function (e) { 

                    let dId = $(this).attr('dId');
                    let user = <?= $user_to_edit->id; ?>;
                    // alert(dId);

                    $.ajax({
                        type: "POST",
                        url: "includes/user_deduction/admin_edit_user_action.php",
                        data: {'deduction_approve': dId, 'user_add_deduction': user},
                        success: function (response) {
                            location.reload(true);
                        }
                    });
                    
                });

                $(".btn_delete_deduction").click(function (e) { 

                    let dId = $(this).attr('dId');
                    
                    // alert(dId);

                    $.ajax({
                        type: "POST",
                        url: "includes/user_deduction/admin_edit_user_action.php",
                        data: {'deduction_delete': dId},
                        success: function (response) {
                            location.reload(true);
                            // alert(response);
                        }
                    });

                });


                //ALLOWANCE ACTION
                $(".btn_add_allowance").click(function (e) { 

                    let aId = $(this).attr('aId');
                    let user = <?= $user_to_edit->id; ?>;
                    // alert(dId);

                    $.ajax({
                        type: "POST",
                        url: "includes/user_allowance/edit_user_action.php",
                        data: {'allowance_approve': aId, 'user_add_allowance': user},
                        success: function (response) {
                            location.reload(true);
                        }
                    });

                });

                $(".btn_delete_allowance").click(function (e) { 

                    let aId = $(this).attr('aId');

                    // alert(dId);

                    $.ajax({
                        type: "POST",
                        url: "includes/user_allowance/edit_user_action.php",
                        data: {'allowance_delete': aId},
                        success: function (response) {
                            location.reload(true);
                            // alert(response);
                        }
                    });

                });

            });

        </script>

        