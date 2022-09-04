<?php require_once "includes/header.php" ?>
<?php require_once "phpqrcode/qrlib.php";
    // phpinfo();
    
    
    

?>

<?php 
if($user->user_role === 'user'){
    redirect('index.php');
}
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        
        if(isset($_POST['add_user'])){
            $new_user = new User();
            

            //INITIALIZE
            $username = validate_input($_POST['username']);
            $password = validate_input($_POST['password']);
            $first_name = validate_input($_POST['first_name']);
            $last_name = validate_input($_POST['last_name']);
            $user_role = validate_input($_POST['user_role']);
            $position = validate_input($_POST['position']);

            //ASSINING
            $new_user->first_name = $first_name;
            $new_user->last_name = $last_name;
            $new_user->username = $username;
            $new_user->user_role = $user_role;
            $new_user->position_id = $position;
            $new_user->password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>11));
            

            if($new_user->set_file($_FILES['user_image'])){
                $new_user->save_user_image();
                $session->message($new_user->first_name . " " . $new_user->last_name . " Successfully created");
                $new_user->create();

                $path = "images/";
                $file = $new_user->id . $new_user->first_name . $new_user->last_name .".png";
                $qr_code = md5($new_user->first_name . $new_user->last_name);

                QRcode::png($qr_code, $path.$file, 'L', 10);

                $new_user->qr_code = $qr_code;
                $new_user->qrcode_path = $file;
                $new_user->save();

                //DEDUCTION CREATION
                if(!empty($_POST['deduction'])){
                    $new_user->create_user_deduction($_POST['deduction']);
                }

                //ALLOWANCE CREATION
                if(!empty($_POST['allowance'])){
                    $new_user->create_user_allowance($_POST['allowance']);
                }


                redirect("users.php");
            
                
            }else{
                $session->message($new_user->first_name . " " . $new_user->last_name . " Successfully created");
                $new_user->create();

                
                $path = "images/";
                $file = $new_user->id . $new_user->first_name . $new_user->last_name .".png";

                $qr_code = md5($new_user->first_name . $new_user->last_name);

                QRcode::png($qr_code, $path.$file, 'L', 10);

                $new_user->qr_code = $qr_code;

                $new_user->qrcode_path = $file;
                $new_user->save();


                //DEDUCTION CREATION
                if(!empty($_POST['deduction'])){   
                    $new_user->create_user_deduction($_POST['deduction']);
                }

                //ALLOWANCE CREATION
                if(!empty($_POST['allowance'])){
                    $new_user->create_user_allowance($_POST['allowance']);
                }

                redirect("users.php");
            }

        }
    }

    $all_deduction = Deduction::find_all();
    $all_allowance = Allowance::find_all();
    $all_position = Position::find_all();
    
?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">User Profile</h1>
                    </div>
                                        

                        <div class="row">
                            <div class="col-lg-12 p-3">
                                
                            <div class="col-lg-10 offset-lg-1">
                            <div class="card">
                                    <div class="card-body">
                                        
                                                <form action="" method="POST" enctype="multipart/form-data">

                                                    <?php 
                                                        if(!empty($new_user->error)){
                                                            echo $file_error = join("<br>", $new_user->error);
                                                        }
                                                    ?>

                                                    <h3 class="primary-color">Personal Information</h3>
                                                    <hr>

                                                    <div class="form-group">
                                                        <label for="">Image</label>
                                                        <input id="" class="form-control-file" type="file" name="user_image">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">First name</label>
                                                        <input id="" class="form-control" type="text" name="first_name"  autofocus required>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="">Last name</label>
                                                        <input id="" class="form-control" type="text" name="last_name" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Username</label>
                                                        <input id="" class="form-control" type="text" name="username"  required>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="">Password</label>
                                                        <input id="" class="form-control" type="password" name="password" required>
                                                    </div>

                                                    <div class="mb-3">
                                                      <label for="" class="form-label">Position</label>
                                                      <select class="form-control" name="position" id="">
                                                        <option value=""> --SELECT-- </option>
                                                        <?php foreach($all_position as $position): ?>
                                                            <option value="<?= $position->id ?>"><?= $position->position_name ?></option>
                                                        <?php endforeach; ?>
                                                      </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="my-select">Role</label>
                                                        <select id="my-select" class="form-control" name="user_role">
                                                            <option value="user" selected>User</option>
                                                            <option value="admin" >Admin</option>
                                                        </select>
                                                    </div>



                                                    <h3 class="primary-color">Deduction</h3>
                                                    <hr>

                                                    <?php if($all_deduction): ?>
                                                        <?php foreach($all_deduction as $deduction): ?>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"  value="<?= $deduction->id ?>"  name="deduction[]"/>
                                                                <label class="form-check-label" ><?= $deduction->name ?></label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>

                                                    <hr>

                                                    <h3 class="primary-color">Allowance</h3>
                                                    <hr>

                                                    <?php if($all_deduction): ?>
                                                        <?php foreach($all_allowance as $allowance): ?>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"  value="<?= $allowance->id ?>"  name="allowance[]"/>
                                                                <label class="form-check-label" ><?= $allowance->name ?></label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>

                                                    <hr>

                                                    <input type="submit" name='add_user' value="Add user" class="btn update_user_btn">

                                                </form>
                                            
                                            
                                        
                                        
                                    </div>
                                </div>
                            </div>
                                



                                
                        </div>
                    
                        

                </div>
                
        <?php require_once "includes/footer.php" ?>