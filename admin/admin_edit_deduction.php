<?php require_once "includes/header.php" ?>
<?php 

    if($user->user_role === 'user'){
        redirect('index.php');
    }    

    if(empty($_GET['dId']) || !isset($_GET['dId']) ){
        die();
    }else{
        $deduction_id = validate_input($_GET['dId']);
        $deduction_to_edit = Deduction::find_by_id($deduction_id);
    }

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if( isset($_POST['submit_deduction']) ){
            $name = validate_input($_POST['name']);
            $amount = validate_input($_POST['amount']);
   
            $deduction_to_edit->name = $name;
            $deduction_to_edit->amount = $amount;
            $deduction_to_edit->save();
            $session->message($deduction_to_edit->name . " was successfully updated");
            redirect('admin_deduction.php');
        }
    }
?>

                

                <?php require_once "includes/side-nav.php" ?>               

                <div class="page-wrapper">
                    <button class="btn toggle-icon">
                        <span> <i class="fas fa-outdent"></i> </span>
                    </button>

                    <div class="page-header">
                        <h1 class="">Edit deduction</h1>
                    </div>
                                        

                        <div class="row p-3">
                            
                            <?php if(!empty($session->message)) echo "<p class='p-1 session_message'> {$session->message} </p>" ?>

                            
                            
                                
                            <div class="col-lg-12">
                            <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <form action="" method="post" enctype="multipart/form-data">

                                                    

                                                    

                                                    <div class="form-group">
                                                        <label for="">Name:</label>
                                                        <input id="" class="form-control" type="text" name="name"  value="<?= $deduction_to_edit->name ?>" >
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Amount:</label>
                                                        <input id="" class="form-control" type="number" name="amount"  value="<?= $deduction_to_edit->amount ?>" >
                                                    </div>

                                                    
                                                    <input type="submit" name='submit_deduction' value="Submit" class="btn update_user_btn">

                                                    </form>
                                            </div>

                                            

                                        </div>
                                            
                                                
                                            
                                            
                                        
                                        
                                    </div>
                                </div>
                                
                                
                            </div>
                            
                            


                                
                            


                                
                            
                        </div>
                    

                </div>
                
        <?php require_once "includes/footer.php" ?>