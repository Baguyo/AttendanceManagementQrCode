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

            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-md navbar-light ">

                <div class="container">
                    <a class="navbar-brand">Attendance Management System</a>
                    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggle-icon">
                            <i class="fas fa-bars"></i>
                        </span>
                    </button>

                    <div id="my-nav" class="collapse navbar-collapse">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </nav>

            <!-- LOGIN CONTAINER -->
            <div class="container mt-5">
                <div class="row ">

                    <div class="col-lg-8 offset-lg-2 offset-md-1" >
                        
                        <video id="preview" height="280"></video>
                        
                    </div>

                    <form action="upload.php" method="post" id="time_in_form">
                        <input type="text" name="qr_code" hidden readonly id="qr_code">
                    </form>
                    
                    

<!--                     <div class="col-lg-6 my-auto text-center clock_container">
                        <h1></h1>
                        
                            <iframe id='clock_lg_screen' src="https://free.timeanddate.com/clock/i8bq0col/n145/szw500/szh500/hoc9b8578/hbw10/hfc754c29/cf100/hnc432f30/fav0/fiv0/mqcfff/mqs4/mql25/mqw12/mqd78/mhcfff/mhs2/mhl5/mhw2/mhd78/mmv0/hhcfff/hhs2/hhl50/hhw8/hmcfff/hms2/hml70/hmw8/hmr4/hscfff/hss3/hsl70/hsw3" frameborder="0" width="500" height="500"></iframe>


                        <iframe id="clock_sm_screen" src="https://free.timeanddate.com/clock/i8bq0col/n145/fn6/fs16/fcf90/tc000/ftb/bas2/bat1/bacfff/pa8/tt0/tw1/th2/tb4" frameborder="0" width="216" height="60"></iframe>
                    </div>

                    <div class="col-lg-6 my-auto">

                        <div class="login-form" >
                            
                            <form method="post" action="" class="form" id="time_in_form">
                                
                            
                                <span id="log_error" class="text-center text-danger"></span>    

                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fas fa-user"></i> </span>
                                    </div>
                                    <input class="form-control" type="text"  name="username" placeholder="Username" aria-label="Recipient's " aria-describedby="my-addon" autofocus>
                                </div>


                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" > <i class="fas fa-key"></i> </span>
                                    </div>
                                    <input class="form-control" type="password"  name="password" placeholder="Password" aria-label="Recipient's " aria-describedby="my-addon">
                                </div>

                                



                                <div class="webcam-container mb-2">
                                    
                                    <div id="webcam" class="d-none"></div>
                                    
                                    <div id="take_photo_btn" class=" action_btn d-block btn text-white">Take Photo</div>
                                    <div id="snap_btn" class=" action_btn d-none btn text-white"> <i class="fas fa-camera"></i> Take photo</div>
                                    <div id="retake_photo_btn" class=" action_btn d-none btn text-white"> <i class="fas fa-sync-alt"></i> Retake photo</div>
                                    <span id='photo_error_message' class="text-danger"></span>
                                </div>

                                
                                

                                <input type="submit" name="submit" value="TIME IN" id="submit_data" class="w-100 btn mt-2">

                            </form>

                        </div>

                    </div> -->

                </div>

            </div>
        

            <div class="modal fade" id="success_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:999999;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h1 class="text-center" id="attendance_status"></h1>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                    </div>
                </div>
            </div>
          
        </div>
        <footer>
            <div>&copy;EmersonBaguyo_attendance_management_system</div>
        </footer>
       

        

        <script src="js/instascan.min.js"></script>

        <!-- JQUERY -->
        <script src="js/jquery.min.js"></script>


        

        <!-- BOOTSTRAP JQUERY -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        

        

        <!-- WEBCAM JAVASCRIPT -->
        <!-- <script src="js/webcam.js"></script> -->

        <!-- CUSTOM JAVASCRIPT -->
        <!-- <script src="js/script.js"></script> -->

        <script>

// const instascan = require('instascan');

const args = { video: document.getElementById('preview') };

window.URL.createObjectURL = (stream) => {
            args.video.srcObject = stream;
            return stream;
};

const scanner = new Instascan.Scanner(args);

            // let scanner = new Instascan.Scanner( {video: document.getElementById('preview')} );
            Instascan.Camera.getCameras().then(function(cameras){
                if(cameras.length > 0){
                    scanner.start(cameras[0]);
                }else{
                    alert("No camera found");
                }
            }).catch(function(e){
                console.error(e);
            });

            scanner.addListener('scan', function(c){
                var qr_code =  document.getElementById('qr_code').value = c;
                if(document.getElementById('qr_code').value.length > 0){
                    
                    $.ajax({
                        type: "POST",
                        url: "upload.php",
                        data: {'qr_code' : qr_code },
                        success: function (response) {


                            document.getElementById('qr_code').value = " ";
                            $("#attendance_status").text(response);
                            $("#success_modal").modal("show");
                            
                            setInterval(function(){
                                $("#success_modal").modal("hide");
                            },3000)
                        }
                    });
                    
                }
            })
        </script>
        
    </body>
</html>

<!-- https://www.aspsnippets.com/Articles/Capture-Image-Photo-from-Web-Camera-Webcam-using-HTML5-and-jQuery-in-ASPNet.aspx
https://www.youtube.com/watch?v=vfMENHg2B_Q -->