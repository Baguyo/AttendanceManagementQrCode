<?php require_once "includes/header.php" ?>
<?php 
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['submit_department'])){
            $name = validate_input($_POST['name']);

            $department = new Department();
            $department->name = $name;
            $department->save();
            $session->message("{$department->name} was successfully added");
            redirect("admin_department.php");

        }
    }
?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Add Department</h1>
                    </div>
                                        

                        <div class="row p-3">
                            
                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>

                            <!-- <?php if(isset($error)) echo "<p class='p-2 session_message'> " . str_replace("_", " ", $error) ." </p>" ?> -->
                            
                                
                            <div class="col-lg-12">
                            <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <form action="" method="post" enctype="multipart/form-data">

                                                    

                                                    

                                                    <div class="form-group">
                                                        <label for="">Name:</label>
                                                        <input id="" class="form-control" type="text" name="name"  >
                                                    </div>
                                                    
                                                    <input type="submit" name='submit_department' value="Submit" class="btn update_user_btn">

                                                    </form>
                                            </div>

                                            

                                        </div>
                                            
                                                
                                            
                                            
                                        
                                        
                                    </div>
                                </div>
                                
                                
                            </div>
                            
                            


                                
                            


                                
                            
                        </div>
                    

                </div>
                
        <?php require_once "includes/footer.php" ?>