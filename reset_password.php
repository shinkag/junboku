<?php 
session_start(); 
include_once("src/htmlheader.php")
?>

<!-- <style>
    .jumbotron{
        background-image: url('img/event_1.png');
        background-size: cover;
    }
</style> -->
<title>Manage Staff</title>
</head>
<body>
<main>
<div class="container">
    <div class="jumbotron text-center">
        <img src="img/jcos_logo.jpg" class="img-rounded">
        <h1> Junboku Event</h1> 
        <h1>Sales Tracker System</h1>
        <h2> Reset Password</h2>
    </div>

<?php if(isset($_SESSION["staff_id"])){ ?>


    <div class="row text-center">
    <div class="col-1">
    </div>
    <div class="col-10 ">

<?php include('src/navigation.php'); ?>

    </div>
    <div class="col-1">
    </div>
    </div>


    <div class="row">
 
        
        
<?php
        include_once 'src/database.php';
        $query='SELECT * FROM staffs WHERE staff_id="'.$_GET['id'].'";';
        $result = mysqli_query($link,$query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $id=$row[0];
                $name=$row[1];
                $email=$row[2];
                $gender=$row[3];
                $contact=$row[4];
                $position=$row[5];
                $password=$row[6];          
?>      
      <div class="row">
            <h1>Reset Password for Staff : <?php ECHO $name;?></h1>
        </div>
        <br>
        <form class="container" id="form-validation" method="post" action="change_password.php">
        <div class="row">
            <label for="staffid">Staff ID</label>
            <input type="text" class="form-control" id="staffid" name="staffid" value="<?php echo $_GET['id']?>" readonly>
            <br>
            <label for="staffname">Staff Name</label>
            <input type="text" class="form-control" id="staffname" name="staffname" value="<?php echo $name?>" readonly>
            <br>
            <label for="pass1" class="form-label">New Password</label>
            <input type="password" class="form-control" id="pass1" name="pass1">

            <br>
        </div>
        <br>
        <div class="row">
        <button type="submit" class="submit btn btn-primary" id="pwdchange" name="pwdchange">Change Password</button>
        <a href="manage_staffs.php"  class="btn btn-primary" role="button" id="cancel" name="cancel">Cancel</a>
        </div>
        <br>
        <br>     
        </form>
        
<?php            

}
        } else {
            echo "No result found";
        }
?>
        </div>
    </form>
    </div>
<?php 

    

    } else {
    header("Location:login.php");
    exit;
    }
?>
</div>
</main>
<?php include_once("src/htmlfooter.php") ?>
</body>
</html>


<script>  


</script>  