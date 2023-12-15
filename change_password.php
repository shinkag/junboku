<?php

    include_once 'src/database.php';

        $sid=$_POST['staffid'];
        $pass1=$_POST["pass1"];
        $pass2=$_POST["pass2"];
 

    $query='UPDATE staffs SET staff_password="'.$pass1.'" WHERE staff_id="'.$sid.'";';
    
    mysqli_query($link,$query);
    
    echo "<script>window.location.href='manage_staffs.php';</script>";
    exit;

?>