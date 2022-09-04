<?php require_once("includes/header.php") ?>
<?php 
    
    

    

    $user_salary = 0;

    if($_SERVER['REQUEST_METHOD'] === "GET"){

        if( isset($_GET['usId']) && !empty($_GET['usId']) ){

            
            
            $user_id = (int)validate_input($_GET['usId']);

            
            $user_to_compute = User::find_by_id($user_id);

            $position = Position::find_by_id($user_to_compute->position_id);

            $user_allowance = Allowance::show_user_allowance($user_to_compute);

            

             


            
            
            

            $user_salary = validate_input($_GET['user_salary']);
            $date_from = validate_input($_GET['date_from']);
            $date_to = validate_input($_GET['date_to']);

            
        }
        
    }else{
        die();
    }
?>



    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <h5>Name: <?= $user_to_compute->first_name ?> <?= $user_to_compute->last_name ?> </h5>   
                <h6>Position: <?= $position->position_name ?></h6>
                <h6>Date: <?= $date_from ?> - <?= $date_to ?> </h6>

            
                

            </div>

            <div class="col-lg-4  col-md-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Earnings</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Basic salary</td>
                                <td><?= $user_salary ?></td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
                <div class="col-lg-4  col-md-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Allowance</th>
                                <th>Amount</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                                
                                <?php 
                                $result_allowance = $user_allowance->get_result();
                                $total_allowance = 0;
                                if($result_allowance->num_rows >= 1){
                                    
                                    while($row = $result_allowance->fetch_assoc()){
                                        echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        $total_allowance += $row['amount'];
                                        echo "</tr>";
                                    }

                                    //SPACING
                                    echo "<tr>";
                                        echo "<td></td>";
                                        echo "<td>  </td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                        echo "<td>Total Allowance</td>";
                                        echo "<td> {$total_allowance} </td>";
                                    echo "</tr>";
                                }else{
                                    echo "<td></td>";
                                    
                                } 
                                mysqli_free_result($result_allowance);
                                ?>

                                
                            
                            
                        </tbody>
                    </table>
                    
                </div>
                <div class="col-lg-4 col- col-md-4">
                    <table class="table">
                        <thead>
                            <tr>
                                
                                <th>Deduction</th>
                                <th>Amount</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $total_deduction = Deduction::show_user_deduction($user_to_compute);
                                $result_deduction = $total_deduction->get_result();
                                $total_deduction = 0;
                                if($result_deduction->num_rows >= 1){
                                    
                                    while($row = $result_deduction->fetch_assoc()){
                                        echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        $total_deduction += $row['amount'];
                                        echo "</tr>";
                                    }

                                    //SPACING
                                    echo "<tr>";
                                        echo "<td></td>";
                                        echo "<td>  </td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                        echo "<td>Total deduction</td>";
                                        echo "<td> {$total_deduction} </td>";
                                    echo "</tr>";
                                }else{
                                    echo "<td></td>";
                                    
                                } 
                                mysqli_free_result($result_deduction);
                                ?>
                        </tbody>
                    </table>
                    
                </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <h4 style="float:right">Net salary:
                <?php 
                    echo ( $user_salary + $total_allowance ) - $total_deduction;
                ?>

            </h4>
            </div>
        </div>
    </div>

<?php require_once("includes/footer.php") ?>
<script>
    window.onload(window.print());
</script>