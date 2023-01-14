<?php
include_once('confiq.php');
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$connection){
    throw new Exception ('Could not connect to database');
}
$query = "SELECT * FROM tasks where complete=0";
$result = mysqli_query($connection, $query);

$queryComplete = "SELECT * FROM tasks where complete=1";
$resultComplete = mysqli_query($connection, $queryComplete);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
    
    
    <title>Document</title>
    
</head>
<body>
    <div class="container">


    
    <?php
    if(mysqli_num_rows($resultComplete) > 0){ ?> 
    <h1>Completed tasks</h1>
    <table>
        <thead>
        <tr><th></th>
            <th>ID</th>
            <th>Tasks</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead> <tbody>

        <?php
        while($cdata= mysqli_fetch_assoc($resultComplete)){ ?> 
        <tr>
            <th><input type="checkbox" name="check" id="check" checked value="<?php echo $cdata['id'] ?>"></th>
            <td><?php echo $cdata['id'] ?></td>
            <td><?php echo $cdata['task'] ?></td>
            <td><?php echo $cdata['date'] ?></td>
            <td><a href="#" class="delete" data-delid="<?php echo $cdata['id'] ?>">Delete</a></td>
        </tr>

        <?php } 
        ?>
        
        </tbody>
    </table>
    <br>
    <?php }
    ?>
    <?php
    if(mysqli_num_rows($result) == 0){ ?>
    <?php
    }else{ ?>
    <h1>Upcomming tasks</h1>
    <table>
        <thead>
        <tr><th></th>
            <th>ID</th>
            <th>Tasks</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead> <tbody>

        <?php
        while($data= mysqli_fetch_assoc($result)){ 
            $timestamp = strtotime($data['date']);
            $date = date('d-m-Y', $timestamp);
            ?> 
        <tr>
            <th><input type="checkbox" name="check" id="check" value="<?php echo $data['id'] ?>"></th>
            <td><?php echo $data['id'] ?></td>
            <td><?php echo $data['task'] ?></td>
            <td><?php echo $date ?></td>
            <td><a href="#" class="delete" data-delid="<?php echo $data['id'] ?>">Delete</a> | <a class="complete" data-taskid="<?php echo $data['id'] ?>" href="#">Complete</a></td>
        </tr>

        <?php } 
        ?>
        
        </tbody>
    </table>
    <?php }
    ?>
    <h1 class="title">Here you can add your tasks</h1>
    <form action="function.php" method="POST">
        <input type="text" name="task" placeholder="Enter your name">
        <input type="date" name="ddate" placeholder="Enter your name">
        <?php $added = $_GET['added'] ??'';
            if($added){
                echo '<p> Task added successfully</p>';
            }
            ?>
        <input type="submit" name="submit" value="Add Task">
        <input type="hidden" name="action" value="add">
    </form>
            
    </div>
<form action="function.php" method="POST" id="delform">
    <input type="hidden" name="action" id="caction" value="delete">
    <input type="hidden" name="deldata" id="deldata">
</form>
<form action="function.php" method="POST" id="completeForm">
    <input type="hidden" name="action" id="caction" value="complete">
    <input type="hidden" name="taskdata" id="taskdata">
</form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        ;(function($){
            $(document).ready(function(){
                $(".complete").on('click',function(){
                    var id = $(this).data("taskid");
                    $("#taskdata").val(id);
                    $("#completeForm").submit();
                });
                $(".delete").on('click', function(){
                    var d_id = $(this).data("delid");
                    $("#deldata").val(d_id);
                    $("#delform").submit();
                });
            });
        })(jQuery);
    </script>

</html>