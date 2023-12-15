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
        <h2> Staff Management</h2>
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
    <form action="update_staff.php" method="post" >
        <div class="row">
            <h1>Staff Detail: <?php ECHO $_GET['staff_name'];?></h1>
        </div>
        <br>
        
<?php
        include_once 'src/database.php';
        $query='SELECT * FROM staffs WHERE staff_id="'.$_GET['staff_id'].'";';
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
            <label for="sid" class="form-label">Staff ID</label>
            <input type="text" class="form-control" id="sid" name="sid" value="<?php echo $id; ?>" readonly>
            <br>
            <label for="name" class="form-label">Staff Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
            <br>
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
            <br>
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact; ?>">
            <br>
            <label for="position" class="form-label">Position</label>
            <select class="form-control" aria-label="Default select example" id="position" name="position">
                <option value="M" <?php if($position == "manager"){ echo ' selected'; }  ?>>Manager</option>
                <option value="F" <?php if($position == "employee"){ echo ' selected'; }  ?>>Employee</option>
            </select>
            <br>
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" aria-label="Default select example" id="gender" name="gender">
                <option value="M" <?php if($gender == "M"){ echo ' selected'; }  ?>>Male</option>
                <option value="F" <?php if($gender == "F"){ echo ' selected'; }  ?>>Female</option>
            </select>
            <br>
        </div>
        <br>
        <div class="row">
        <button type="submit" class="submit btn btn-primary" id="update" name="update">Update</button>
        <a href="reset_password.php?id=<?php echo $id?>" class="btn btn-primary" role="button" id="reset" name="reset">Reset Password</a>
        <a href="manage_staffs.php"  class="btn btn-primary" role="button" id="cancel" name="cancel">Cancel</a>
        </div>
        <br>
        <br>     
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