<?php require_once "includes/header.php" ?>
<?php 

if($user->user_role === 'user'){
    redirect('index.php');
}

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if( isset($_POST['submit_allowance']) ){
            $name = validate_input($_POST['name']);
            $amount = validate_input($_POST['amount']);

            $new_deduction = new Allowance();
            $new_deduction->name = $name;
            $new_deduction->amount = $amount;
            $new_deduction->save();
            $session->message("Allowance was successfully added");
            redirect('allowance.php');
        }
    }
?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Add allowance</h1>
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

                                                    <div class="form-group">
                                                        <label for="">Amount:</label>
                                                        <input id="" class="form-control" type="number" name="amount" >
                                                    </div>

                                                    
                                                    <input type="submit" name='submit_allowance' value="Submit" class="btn update_user_btn">

                                                    </form>
                                            </div>

                                            

                                        </div>
                                            
                                                
                                            
                                            
                                        
                                        
                                    </div>
                                </div>
                                
                                
                            </div>
                            
                            


                                
                            


                                
                            
                        </div>
                    

                </div>
                
        <?php require_once "includes/footer.php" ?>