<?php 

require_once "includes/function.php";
require_once "includes/init.php";

?>
<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['submit'])){
            // echo "hey";
            $username = validate_input($_POST['username']);
            $password = validate_input($_POST['password']);

            $user = User::verify_user($username, $password);
            if($user){
                if($user->user_role == "admin"){
                    header("Location: admin/check_attendance.php");
                }else{
                    header("Location: user");
                }
                
                // echo $user;
            }else{
                $error_message = "incorrect username or password";
            }
        }
        
    }
?>

<!DOCTYPE html>


<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- FONTAWESOME -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
        <script src="https://kit.fontawesome.com/573a5c3258.js" crossorigin="anonymous"></script>

        <!-- BOOSTRAP -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <link rel="stylesheet" href="css/style.css">
        
    </head>
    <body>
        
        <div class="wrapper ">

         
            <!-- LOGIN CONTAINER -->
            <div class="container">
                <div class="row ">


                    <div class="col-lg-6 my-auto offset-lg-3">

                        <div class="login-form" >
                            
                        
                            <form method="POST" action="" class="form">
        
                            <h1 class="text-center mb-3 title-page">Attendance Management Login</h1>        
                            
                                
                            <?php echo isset($error_message) ? "<h4 class='text-center text-danger'>{$error_message}</h4>" : "" ?>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user-large"></i> </span>
                                    </div>
                                    <input class="form-control" type="text" name="username" placeholder="Username" aria-label="Recipient's " aria-describedby="my-addon" autofocus>
                                </div>


                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" > <i class="fas fa-key"></i> </span>
                                    </div>
                                    <input class="form-control" type="password" name="password" placeholder="Password" aria-label="Recipient's " aria-describedby="my-addon">
                                </div>

                                <!-- <div class="form-group">
                                    <label for="my-input">Text</label>
                                    <input type="file" id="mypic" accept="image/*" capture="camera">
                                </div> -->



                                <!-- <div class="webcam-container"> -->
                                    <!-- <img src="" alt="" id="img_capture"> -->
                                    <!-- <video id="webcam" class="" autoplay playsinline width="320" height="240"></video> -->
                                    <!-- <div id="webcam" class="d-none"></div> -->
                                    <!-- <canvas id="canvas" class="d-none"></canvas> -->
                                    <!-- <br> -->
                                    <!-- <audio id="snapSound" src="audio/snap.wav" preload = "auto"></audio> -->
                                    <!-- <div id="take_photo_btn" class=" action_btn d-block btn text-white">Take Photo</div>
                                    <div id="snap_btn" class=" action_btn d-none btn text-white"> <i class="fas fa-camera"></i> Take photo</div>
                                    <div id="retake_photo_btn" class=" action_btn d-none btn text-white"> <i class="fas fa-sync-alt"></i> Retake photo</div> -->
                                <!-- </div> -->

                                <!-- <img src="https://place-hold.it/768x1024" alt=""> -->

                                <input type="submit" name="submit" value="Sign in" id="submit_data" class="w-100 btn">

                            </form>

                        </div>

                    </div>

                </div>

            </div>
        
          
        </div>
        <footer>
            <div>&copy;EmersonBaguyo_attendance_management_system</div>
        </footer>
       

        


        <!-- JQUERY -->
        <script src="js/jquery.min.js"></script>

        <!-- BOOTSTRAP JQUERY -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        
        <!-- WEBCAM JAVASCRIPT -->
        <!-- <script src="js/webcam.js"></script> -->

        <!-- CUSTOM JAVASCRIPT -->
        <!-- <script src="js/script.js"></script> -->

    </body>
</html>

<!-- https://www.aspsnippets.com/Articles/Capture-Image-Photo-from-Web-Camera-Webcam-using-HTML5-and-jQuery-in-ASPNet.aspx
https://www.youtube.com/watch?v=vfMENHg2B_Q -->