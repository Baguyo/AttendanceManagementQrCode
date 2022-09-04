<?php require_once "includes/header.php" ?>
<?php 
    

    if(isset($_GET['image'])){
        $file = $_GET['image'];
        if(file_exists($file)){
            User::download_qr_code($file);
            
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        // $user->set_file($_FILES['user_image']);
        // echo $user->user_image;
        if(isset($_POST['update_user'])){
            // var_dump($_FILES);
            // $user->set_file($_FILES['user_image']);
            // $user->save_user_image();
            // $user->save();

            $username = validate_input($_POST['username']);
            $password = validate_input($_POST['new_password']);
            $first_name = validate_input($_POST['first_name']);
            $last_name = validate_input($_POST['last_name']);

            $user->username = $username;
            $user->first_name = $first_name;
            $user->last_name = $last_name;

            if(!empty($_POST['new_password'])){
                $user->password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>11));;
            }

            if($user->set_file($_FILES['user_image'])){
                $user->save_user_image();
                $user->save();
                $session->message("Profile was successfully updated");
                redirect("profile.php");
            // }elseif(!empty($user->error)){
            //     var_dump($user->error);
            }else{
                $user->save();
                $session->message("Profile was successfully updated");
                redirect("profile.php");
            }

        }
    }

    //INITIALIZE USER DEDUCTION
    $user_deduction = Deduction::show_user_deduction($user);
    if($user_deduction){
        $user_deduction->bind_result($user_id, $deduction_id, $deduction_amount, $deduction_name);
    }else{
        $user_deduction = [];
    }


    
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
                            <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row">

                                            <div class="col-lg-8">
                                                <form action="" method="post" enctype="multipart/form-data">

                                                    <?php 
                                                        if(!empty($user->error)){
                                                            echo $file_error = join("<br>", $user->error);
                                                        }
                                                    ?>

                                                    <div class="form-group">
                                                        <label for="">Image</label>
                                                        <input id="" class="form-control-file" type="file" name="user_image">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">First name</label>
                                                        <input id="" class="form-control" type="text" name="first_name" value="<?php echo $user->first_name; ?>" >
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Last name</label>
                                                        <input id="" class="form-control" type="text" name="last_name" value="<?=$user->last_name?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Username</label>
                                                        <input id="" class="form-control" type="text" name="username" value="<?=$user->username?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">New password</label>
                                                        <input id="" class="form-control" type="text" name="new_password">
                                                    </div>

                                                    <input type="submit" name='update_user' value="Update profile" class="btn update_user_btn">

                                                    </form>
                                            </div>

                                            <div class="col-lg-4">

                                                <div class="card mb-3">
                                                    <div class="card-body bg-light">
                                                        <h4 class="card-title primary-color">Deduction</h4>
                                                        <ul class="list-group">
                                                            
                                                            <?php 
                                                            
                                                                while($user_deduction->fetch()){
                                                                    echo "<li class='list-group-item'> &#8369;{$deduction_amount}  {$deduction_name}  </li>";
                                                                }
                                                                
                                                            ?>
                                                        
                                                            
                                                            
                                                        </ul>
                                                    </div>
                                                </div>


                                                <div class="card mb-3">
                                                    <div class="card-body bg-light">
                                                        <h4 class="card-title primary-color">Allowance</h4>
                                                        <ul class="list-group">
                                                            
                                                            <?php 
                                                            $user_allowance = Allowance::show_user_allowance($user);
                                                            if($user_allowance){
                                                                $user_allowance->bind_result($user_id, $allowance_id, $allowance_amount, $allowance_name);
                                                            }else{
                                                                $user_allowance = [];
                                                            }
                                                            
                                                                while($user_allowance->fetch()){
                                                                    echo "<li class='list-group-item'> &#8369;{$allowance_amount}  {$allowance_name}  </li>";
                                                                }

                                                            ?>
                                                        
                                                            
                                                            
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                  <div class="card-body">
                                                    <img src="<?php echo $user->display_user_qr_code() ?>" alt="" class="img-responsive img-thumbnail" height="250px" width="100%">
                                                    <a href="profile.php?image=<?php echo $user->display_user_qr_code() ?>" id="profile-qrcode-btn" class="btn mt-2 ">Download</a>
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