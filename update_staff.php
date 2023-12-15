<?php

    include_once 'src/database.php';

        $sid=$_POST["sid"];
        $name=$_POST["name"];
        $email=$_POST['email'];
        $gender=$_POST["gender"];
        $contact=$_POST["contact"];
        $position=$_POST["position"];
    
    $query=' UPDATE staffs SET staff_name="'.$name.'", staff_email="'.$email.'", staff_gender="'.$gender.'", staff_contact="'.$contact.'", staff_position="'.$position.'" WHERE staff_id="'.$sid.'";';
    //echo $query;
    $result = mysqli_query($link,$query);

    // header("Location:manage_staffs.php");
    // exit;
    echo "<script>window.location.href='manage_staffs.php';</script>";
    exit;
?>