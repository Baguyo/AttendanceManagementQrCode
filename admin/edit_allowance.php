<?php require_once "includes/header.php" ?>
<?php 


    if(empty($_GET['aId']) || !isset($_GET['aId']) ){
        die();
    }else{
        $allowance_id = validate_input($_GET['aId']);
        $allowance_to_edit = Allowance::find_by_id($allowance_id);
    }

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if( isset($_POST['submit_allowance']) ){
            $name = validate_input($_POST['name']);
            $amount = validate_input($_POST['amount']);
   
            $allowance_to_edit->name = $name;
            $allowance_to_edit->amount = $amount;
            $allowance_to_edit->save();
            $session->message($allowance_to_edit->name . " was successfully updated");
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
                        <h1 class="">Edit allowance</h1>
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
                                                        <input id="" class="form-control" type="text" name="name"  value="<?= $allowance_to_edit->name ?>" >
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Amount:</label>
                                                        <input id="" class="form-control" type="number" name="amount"  value="<?= $allowance_to_edit->amount ?>" >
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