<?php  require_once "../function.php" ?>
<?php  require_once "../../../common/classes/Database.php" ?>
<?php  require_once "../../../common/classes/DB_object.php" ?>
<?php  require_once "../../../common/classes/Attendance.php" ?>
<?php  require_once "../../../common/classes/Appeal.php" ?>
<?php 


if(isset($_POST['appeal_date'])){

    
    $appeal_usId = validate_input($_POST['appeal_usId']);
    $appeal_status = validate_input($_POST['appeal_status']);
    $appeal_date = validate_input($_POST['appeal_date']);

    $appeal = Appeal::find_appeal_by_column($appeal_usId, $appeal_date, $appeal_status);

    

    if($appeal->status === "pending"){
        $status =  "<div class='badge bg-primary text-white p-2' >  $appeal->status </div> ";
        
    }elseif($appeal->status === "approve"){
        $status = " <div class='badge bg-success text-white p-2'  >  $appeal->status </div>";
    }elseif($appeal->status === "denied"){
        $status =  " <div class='badge bg-danger text-white p-2'  >  $appeal->status </div> ";
    }

    
    echo "<table class='table table-bordered'>
            <thead>
                <tr>
                    <th>DATE</th>
                    <th>REASON</th>
                    <th>ATTEND STATUS</th>
                    <th>TIME</th>
                    <th>STATUS</th>
                    <th colspan='2'>ACTION</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$appeal->date}</td>
                    <td>{$appeal->reason}</td>
                    <td>" .str_replace("_", " ", $appeal->time_status) ."</td>
                    <td>{$appeal->time}</td>
                    <td>{$status}</td>
                    
                    <td> <span> 
                                                            

                            <button title='Denied' type='submit' class='btn btn-dark denied_btn' appId={$appeal->id} > <i class='fas fa-exclamation'></i> </button>
                            
                            <button title='Approve' type='submit' class='btn btn-success approve_btn' appId={$appeal->id} > <i class='fas fa-thumbs-up'></i> </button>                                                            
                        
                    </span> </td>
                </tr>
            </tbody>
        </table>
    ";

}else{
    die();
}




?>

<script>
    $(".approve_btn").click(function (e) { 
                    e.preventDefault();

                    let appId = $(this).attr('appId');

                    $.ajax({
                        type: "POST",
                        url: "includes/appeal/admin_action_appeal.php",
                        data: {'appId_approve':appId},
                        success: function (response) {
                            if(!response.data){
                                window.location.reload(1)
                            }
                        }
                    });
                    
                });

                $(".denied_btn").click(function (e) { 
                    e.preventDefault();

                    let appId = $(this).attr('appId');

                    // alert(appId);

                    $.ajax({
                        type: "POST",
                        url: "includes/appeal/admin_action_appeal.php",
                        data: {'appId_denied':appId},
                        success: function (response) {
                            if(!response.data){
                                window.location.reload(1)
                            }
                        }
                    });
                    
                });
</script>