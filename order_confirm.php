<?php 
session_start(); 
include_once("src/htmlheader.php")
?>

<title>Order Form</title>
</head>
<body>
<main>
<div class="container">
    <div class="jumbotron text-center">
        <img src="img/jcos_logo.jpg" class="img-rounded">
        <h1> Junboku Event</h1> 
        <h1>Sales Tracker System</h1>
        <h2>Order Confirmation</h2>
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



    <form action="order_confirm.php?po=<?php echo  $_GET['po']?>&event_id=<?php echo $_GET['event_id'] ?>" method="post" > 
        <br>
        
        <?php
                include_once 'src/database.php';
                $event='SELECT * FROM events WHERE event_id='.$_GET['event_id'].';';
                $result = mysqli_query($link,$event);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                    $event_name=$row['event_name'];
                    $event_location=$row['event_location'];
                    }
                }
        
              
?>      
        <table>
        <tr>
            <td>PO</td>
            <td>&nbsp:&nbsp</td>
            <td><?php echo $_GET['po']?></td>
        </tr>
        <tr>
            <td>Date</td>
            <td>&nbsp:&nbsp</td>
            <td><?php echo date("d-M-Y") ?></td>
        </tr>
        <tr>
            <td>Event Name</td>
            <td>&nbsp:&nbsp</td>
            <td><?php echo $event_name; ?></td>
        </tr>
        <tr>
            <td>Event Location</td>
            <td>&nbsp:&nbsp</td>
            <td><?php echo $event_location; ?></td>
        </tr>
        </table>

        <table class='table table-bordered table-striped' id="order_table"> 
        <br>
        <tr class="header">
                <td><b>Guest</b></td>
                <td><b>Merchandise Name</b></td>
                <td><b>Unit Price ($)</b></td>
                <td><b>Quantity</b></td>
                <td><b>Total</b></td>
            </tr>
        <?php
        include_once 'src/database.php';
        $orderlist='SELECT * FROM orders WHERE order_no="'.$_GET['po'].'";';
        $result = mysqli_query($link,$orderlist);
    
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            $guest_sql = 'SELECT guest_name FROM guests WHERE guest_id='.$row['guest_id'].'; ';
            $guest_result = mysqli_query($link,$guest_sql);
            while($grow = mysqli_fetch_array($guest_result)) {
                echo '<td>'.$grow['guest_name'].'</td>';
            }
            $eachsql='SELECT * FROM merchandises WHERE merchandise_id='.$row['merchandise_id'].' LIMIT 1';
            $results2 = mysqli_query($link,$eachsql);
            while($row2 = mysqli_fetch_array($results2)) {
                echo '<td>'.$row2['merchandise_name'].'</td>';
                echo '<td>'.$row2['merchandise_price'].'</td>';
            }
            echo '<td>'.$row['order_quantity'].'</td>';
            echo '<td> $ '.$row['order_total_price'].'</td>';
            echo '</tr>';
            $sub_total = 0;
            $sub_total=$sub_total+$row['order_total_price'];
            $paymentsql='SELECT payment_type FROM payment_types WHERE payment_type_id='.$row['payment_type_id'].' LIMIT 1;';
            $result3 = mysqli_query($link,$paymentsql);
            while($row3 = $result3->fetch_assoc()) {
                $payment_type=$row3['payment_type'];
            }
        }

        echo '<tr><td></td><td></td><td></td><td></td><td><b>Payment Type : </b>'.$payment_type.'</td></tr>';
        echo '<tr><td></td><td></td><td></td><td></td><td><b>Sub Total : </b>$ '.$sub_total.'</td></tr>';
        ?>
        </table>
     
    <br>
       
        <div class="row">
        <input type="hidden" id="orderno" name="orderno" value="<?php echo $_GET['po']?>">
        <button type="submit" class="btn btn-primary" id="order" name="order">Confirm Order</button>
        <a href="main_page.php"  class="btn btn-primary" role="button" id="cancel" name="cancel">Cancel</a>
        </div>
        <br>
        </div>
    </form>
<?php        
    if(isset($_POST['orderno'])){
        include_once "src/database.php";
        $query=' UPDATE orders SET status="completed"  WHERE order_no="'.$_POST['orderno'].'";';
        $result = mysqli_query($link,$query);
        
        echo '<script>window.location.href="order_form.php?event_id='.$_GET['event_id'].'";</script>';
        //header('Location:order_confirm.php?po='.$nextPoNumber);
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

