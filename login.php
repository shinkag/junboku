<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <title>Login</title>
</head>
<body>
<main>
    <form action="login.php" method="post">
        <h1>Login</h1>
        <div>
            <label for="staff_id">Employee ID:</label>
            <input type="text" name="staff_id" id="staff_id">
        </div>
        <div>
            <label for="staff_password">Password:</label>
            <input type="password" name="staff_password" id="staff_password">
        </div>
        <section>
            <button type="submit">Login</button>
        </section>
    </form>
</main>
</body>
</html>


<?php

    include_once "src/database.php";

    if(isset($_POST["staff_id"], $_POST["staff_password"]))
    {
        $staff_id = $_POST["staff_id"];
        $staff_password = $_POST["staff_password"];
       
        $sql = "SELECT staff_id, staff_name, staff_position FROM staffs WHERE staff_id='$staff_id' AND staff_password='$staff_password' ";
        $result = mysqli_query($link,$sql);

        // FAILED LOGIN
        if (mysqli_num_rows($result)==0)
        {
                echo "Nothing found here";
                $failed=1;
        }
        // SUCCESS LOGIN
        else
        {
            echo "Found! Login OK!";
            $row = $result->fetch_row();

            $staff_id = $row[0];
            $staff_name = $row[1];
            $staff_position = $row[2];

            session_start();
            $_SESSION['staff_id']=$staff_id;
            $_SESSION['staff_name']=$staff_name;
            $_SESSION['staff_position']=$staff_position;


            header("Location:main_page.php");
            exit;
        }
    } else {
        
    }
    
?>
