<?php

    include_once 'src/database.php';

        $guest_id=$_POST["guest_id"];
        $guest_name=$_POST["guest_name"];
        $guest_email=$_POST['guest_email'];
        $guest_gender=$_POST["guest_gender"];
        $guest_country=$_POST["guest_country"];
        $guest_contact=$_POST["guest_contact"];
    
    $query=' UPDATE guests SET guest_name="'.$guest_name.'", guest_email="'.$guest_email.'", guest_gender="'.$guest_gender.'", guest_country="'.$guest_country.'", guest_contact="'.$guest_contact.'" WHERE guest_id="'.$guest_id.'";';

    $result = mysqli_query($link,$query);

    // header("Location:manage_guests.php");
    // exit;
    echo "<script>window.location.href='manage_guests.php';</script>";
    exit;

?>