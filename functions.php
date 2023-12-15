<?php


function getGuestFromDatabase(){
    
    include_once "src/database.php";
    
    $sql="SELECT * FROM guests;";
    $result = mysqli_query($link,$sql);
    $guests = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $guests[] = $row;
        }
    }
    return $guests;

}

?>