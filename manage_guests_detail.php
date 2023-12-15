<?php 
session_start(); 
include_once("src/htmlheader.php")
?>

<title>Manage Guest</title>
</head>
<body>
<main>
<div class="container">
    <div class="jumbotron text-center">
        <img src="img/jcos_logo.jpg" class="img-rounded">
        <h1> Junboku Event</h1> 
        <h1>Sales Tracker System</h1>
        <h2> Guest Management</h2>
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
    <form action="update_guest.php" method="post" >
        <div class="row">
            <h1>Guest Detail: <?php ECHO $_GET['guest_name'];?></h1>
        </div>
        <br>
        
<?php
        include_once 'src/database.php';
        $query='SELECT * FROM guests WHERE guest_id="'.$_GET['guest_id'].'";';
        $result = mysqli_query($link,$query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $guest_id=$row['guest_id'];
                $guest_name=$row['guest_name'];
                $guest_email=$row['guest_email'];
                $guest_gender=$row['guest_gender'];
                $guest_contact=$row['guest_contact'];
                $guest_country=$row['guest_country'];
              
?>      
      
        <div class="row">
            <label for="guest_id" class="form-label">Guest ID</label>
            <input type="text" class="form-control" id="guest_id" name="guest_id" value="<?php echo $guest_id ?>" readonly>
            <br>
            <label for="guest_name" class="form-label">Guest Name</label>
            <input type="text" class="form-control" id="guest_name" name="guest_name" value="<?php echo $guest_name; ?>">
            <br>
            <label for="guest_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="guest_email" name="guest_email" value="<?php echo $guest_email; ?>">
            <br>
            <label for="guest_contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="guest_contact" name="guest_contact" value="<?php echo $guest_contact; ?>">
            <br>
            <label for="guest_country" class="form-label">Country</label>
            <input type="text" class="form-control" id="guest_country" name="guest_country" value="<?php echo $guest_country; ?>">
            <br>
            <label for="guest_gender" class="form-label">Gender</label>
            <select class="form-control" aria-label="Default select example" id="guest_gender" name="guest_gender">
                <option value="M" <?php if($guest_gender == "M"){ echo ' selected'; }  ?>>Male</option>
                <option value="F" <?php if($guest_gender == "F"){ echo ' selected'; }  ?>>Female</option>
            </select>
            <br>
        </div>
        <br>
        <div class="row">
        <button type="submit" class="submit btn btn-primary" id="update" name="update">Update</button>
        <a href="manage_guests.php"  class="btn btn-primary" role="button" id="cancel" name="cancel">Cancel</a>
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