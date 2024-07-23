

<?php
session_start();
if (!isset($_SESSION["userdata"])) {
    header("Location: ../");  
    exit();  
}
$userdata = $_SESSION['userdata'];  // Use square brackets for array access
$groupdata = $_SESSION['groupdata'];  // Assuming this is correctly initialized somewhere else

if($_SESSION['userdata']['status']==0)
{
    $status='<b style="color:red">Not voted</b>';
}
else{
    $status= '<b style="color:green">voted</b>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System - Dashboard</title>
    <link rel="stylesheet" href="./dash.css">
</head>
<body>
    <style>
        body{
            background-image: url(./bg.jpeg);
        }
    </style>
    
    <div id="mainsection">
        <center>
    <div id="headersection">
    <a href="index.html"><button id="backbtn">back</button></a>
    <a href="index.html"><button id="logoutbtn">logout</button></a>
    <h1>Online-Voting-System</h1>
    </div>
    </center>
    <hr>
    <div id="profile">
        <center>
 <img src="./uploads/<?php echo $userdata['photo'] ?>"height="200" width="200"></b></center><br><br><br>
 <h3>Name --- <?php echo $userdata['name']?></h3>
 <h3>Mobile --- <?php echo $userdata['mobile']?></h3>
 <h3>Department --- <?php echo $userdata['department']?></h3>
 <h3>Status --- <?php echo $status?></h3><br>
    </div>

    <div id="group">

    <?php
        if($_SESSION['groupdata']) 
        {
            for($i= 0;$i<count($groupdata) ; $i++)
            {
                ?>
           <div>
                    <img style="float: right;" src="./uploads/<?php echo $groupdata[$i]['photo']?>" height="100" width="100"><br>
                    <h3>Group Name: <?php echo $groupdata[$i]['name']?></h3>
                    <h3>Votes: <?php echo $groupdata[$i]['votes']?></h3>
                    <form action="vote.php" method="POST">
                        <input type="hidden" name="gvotes" value="<?php echo $groupdata[$i]['votes']?>">
                        <input type="hidden" name="gid" value="<?php echo $groupdata[$i]['id']?>">

                        <?php  
                        if($_SESSION['userdata']['status']==0)
                        {
                            ?>
                            <input type="submit" name="votebtn" id="votebtn" value="vote">
                            <?php
                        }
                        else{
                            ?>
                            <button disabled type="button" name="votebtn" value="vote" id="voted">voted</button>
                            <?php
                        }
                        
                        ?>
                        
                    </form>
                </div>
                <hr>
                <hr>
                <?php
            }
        }
        ?>
    </div>
    </div>
</body>
</html>
























