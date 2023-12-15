<?php
include "src/database.php";

if(isset($_POST['options'])) {

    $event_id = $_GET['event_id'];
    $guest_id= $_GET['guest_id'];
    $values = $_POST['options'];
    $valuelist = "'" . implode("', '", $values) . "'";

    $getQuery = 'SELECT events.event_name,
                        events.event_start_date, 
                        guests.guest_name, 
                        merchandises.merchandise_name, 
                        payment_types.payment_type, 
                        SUM(orders.order_quantity) AS total_quantity, 
                        SUM(orders.order_total_price) AS total_amount,
                        orders.order_no as order_no
                FROM orders
                LEFT JOIN events ON orders.event_id = events.event_id
                LEFT JOIN guests ON orders.guest_id = guests.guest_id
                LEFT JOIN merchandises ON orders.merchandise_id = merchandises.merchandise_id
                LEFT JOIN payment_types ON orders.payment_type_id = payment_types.payment_type_id
                WHERE events.event_id ='.$event_id.' and orders.payment_type_id IN ('.$valuelist.') and orders.guest_id LIKE "'.$guest_id.'"
                
                GROUP BY events.event_name, 
                        events.event_start_date, 
                        guests.guest_name, 
                        merchandises.merchandise_name, 
                        payment_types.payment_type,
                        order_no;';

    // return filtered result to replace result in report table 

    $result = mysqli_query($link, $getQuery);
    $total_quantity_sum=0;
    $total_amount_sum=0;

    while ($row = mysqli_fetch_array($result)) {
    $event_date=substr($row['order_no'],2,4).'-'.substr($row['order_no'],6,2).'-'.substr($row['order_no'],8,2);
    echo '<tr>';
    echo '<td>'.$row['event_name'].'</td>';
    echo '<td>'.$event_date.'</td>';
    echo '<td>'.$row['guest_name'].'</td>';
    echo '<td>'.$row["merchandise_name"].'</td>';
    echo '<td>'.$row["total_quantity"].'</td>';
    echo '<td>$ '.$row["total_amount"].'</td>';
    echo '<td>'.$row["payment_type"].'</td>';
    echo '</tr>';
    
    $total_quantity_sum += $row["total_quantity"];
    $total_amount_sum += $row["total_amount"];      
    }

// Display the sum row
    
    echo '<tr class="sum-row">
        <td colspan="4">Total</td>
        <td>'.$total_quantity_sum.'</td>
        <td>$ '.$total_amount_sum.'</td>
        <td></td>
    </tr>';


    }
?>