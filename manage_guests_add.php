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

    <?php if(isset($_SESSION["staff_id"])){  
        $logon_id=$_SESSION["staff_id"];
    ?>

    <div class="row text-center">
    <div class="col-1">
    </div>
    <div class="col-10 ">

    </div>
    <div class="col-1">
    </div>
    </div>

    <div class="row">
    <form action="manage_guests_add.php" method="post">
        <div class="row">
            <h1>New Guest</h1>
        </div>
        <br>
    
        <div class="row">
            <label for="guest_id" class="form-label">Staff ID</label>
            <input type="text" class="form-control" id="guest_id" name="guest_id" disabled  placeholder="Auto Generate">
            <br>
            <label for="guest_name" class="form-label">Guest Name</label>
            <input type="text" class="form-control" id="guest_name" name="guest_name"  required>
            <br>
            <label for="guest_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="guest_email" name="guest_email"   required >
            <br>
            <label for="guest_contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="guest_contact" name="guest_contact" required>
            <br>
            <label for="guest_country" class="form-label">Guest Country</label>
            <input type="text" class="form-control" id="guest_country" name="guest_country"  required>
            <br>
            <label for="guest_gender" class="form-label">Gender</label>
            <select class="form-control" aria-label="Default select example" id="guest_gender" name="guest_gender">
                <option value="M" >Male</option>
                <option value="F" >Female</option>
            </select>
            <br>
        </div>
        <br>
        <div class="row">
        <button type="submit" class="btn btn-primary" id="add" name="add">Add Guest</button>
        <!-- <button type="button" class="btn btn-primary"><a href="javascript:history.go(-1)"></a>Cancel</button> -->
        <a href="manage_guests.php"  class="btn btn-primary" role="button" id="cancel" name="cancel">Cancel</a>
        </div>
        <br>
        <br>     
       
        </div>
    </form>
    </div>
<?php 
    if(isset($_POST['guest_name'])){
        include_once "src/database.php";
        $guest_name=$_POST['guest_name'];
        $guest_email=$_POST['guest_email'];
        $guest_contact=$_POST['guest_contact'];
        $guest_country=$_POST['guest_country'];
        $guest_gender=$_POST['guest_gender'];

        $sql='INSERT INTO guests(guest_name, guest_email, guest_contact, guest_country, guest_gender, staff_id) values("'.$guest_name.'","'.$guest_email.'","'.$guest_contact.'", "'.$guest_country.'", "'.$guest_gender.'", "'.$logon_id.'");';
        $result = mysqli_query($link,$sql);
    
        // header("Location:manage_guests.php");
        // exit;
        echo "<script>window.location.href='manage_guests.php';</script>";
        exit;

    }

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
