<?php 
session_start(); 
include_once("src/htmlheader.php")
?>

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

    </div>
    <div class="col-1">
    </div>
    </div>

    <div class="row">
    <form action="manage_staffs_add.php" method="post">
        <div class="row">
            <h1>New Staff</h1>
        </div>
        <br>
    
        <div class="row">
            <label for="staff_id" class="form-label">Staff ID</label>
            <input type="text" class="form-control" id="staff_id" name="staff_id" disabled  placeholder="Auto Generate">
            <br>
            <label for="password" class="form-label">Staff Name</label>
            <input type="text" class="form-control" id="staff_name" name="staff_name"  required>
            <br>
            <label for="staff_name" class="form-label">Set password</label>
            <input type="password" class="form-control" id="password" name="password"  required>
            <br>
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"   required >
            <br>
            <label for="contact" class="form-label" >Contact</label>
            <input type="text" class="form-control" id="contact" name="contact"  required>
            <br>
            <label for="position" class="form-label">Position</label>
            <select class="form-control" aria-label="Default select example" id="position" name="position">
                <option value="manager">Manager</option>
                <option value="employee">Employee</option>
            </select>
            <br>
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" aria-label="Default select example" id="gender" name="gender">
                <option value="M" >Male</option>
                <option value="F" >Female</option>
            </select>
            <br>
        </div>
        <br>
        <div class="row">
        <button type="submit" class="btn btn-primary" id="add" name="add">Add Staff</button>
        <!-- <button type="button" class="btn btn-primary"><a href="javascript:history.go(-1)"></a>Cancel</button> -->
        <a href="manage_staffs.php"  class="btn btn-primary" role="button" id="cancel" name="cancel">Cancel</a>
        </div>
        <br>
        <br>     
       
        </div>
    </form>
    </div>
<?php 

if(isset($_POST["position"])){
    
    include_once "src/database.php";
    $name=trim($_POST["staff_name"]);
    $email=trim($_POST["email"]);
    $password=trim($_POST["password"]);
    $position=$_POST["position"];
    $contact=trim($_POST["contact"]);
    $gender=$_POST["gender"];

    if($_POST['position']=="manager"){
        $sql1='SELECT staff_id FROM staffs WHERE staff_position="manager" ORDER BY staff_id DESC LIMIT 1;';
        $result1=mysqli_query($link,$sql1);
        $row1=mysqli_fetch_array($result1);
        $latest_id=$row1['staff_id'];
        list($staff_prefix,$staff_num) = sscanf($latest_id,"%[A-Za-z]%[0-9]");
        $new_id= $staff_prefix . str_pad($staff_num + 1,3,'0',STR_PAD_LEFT);
    }
    if($_POST['position']=="employee"){
        $sql1='SELECT staff_id FROM staffs WHERE staff_position="employee" ORDER BY staff_id DESC LIMIT 1;';
        $result1=mysqli_query($link,$sql1);
        $row1=mysqli_fetch_array($result1);
        $latest_id=$row1['staff_id'];
        list($staff_prefix,$staff_num) = sscanf($latest_id,"%[A-Za-z]%[0-9]");
        $new_id=$staff_prefix . str_pad($staff_num + 1,3,'0',STR_PAD_LEFT);
    }
    $sql='INSERT INTO staffs(staff_id, staff_name, staff_password, staff_email, staff_gender, staff_contact, staff_position) values("'.$new_id.'","'.$name.'","'.$password.'", "'.$email.'", "'.$gender.'", "'.$contact.'", "'.$position.'");';
    $result = mysqli_query($link,$sql);
    
    // header("Location:manage_staffs.php");
    // exit;
    echo "<script>window.location.href='manage_staffs.php';</script>";
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
