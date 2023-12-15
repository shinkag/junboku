<?php 
session_start(); 
include("src/htmlheader.php")
?>

<!-- <style>
    .jumbotron{
        background-image: url('img/event_1.png');
        background-size: cover;
    }
</style> -->
<title>View Report</title>
</head>
<body>
<main>
<div class="container">
    <div class="jumbotron text-center">
        <img src="img/jcos_logo.jpg" class="img-rounded">
        <h1> Junboku Event</h1> 
        <h1>Sales Tracker System</h1>
        <h2> Report</h2>
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

    <form action="report.php" method="post" style="margin-top:50px, margin-left:100px">
        <div class="row">
            <h1>Report</h1>
       
        <div class="row">
        <br>
        <!-- <input class='form-control' type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for event.."> -->
        
        <div class="row">
        <label class="form-label">Guest Name</label>
        <select id="guest_id" name="guest_id" class="form-control gid" onchange="guestChange()">
        <option value="%"></option>
        <?php 
            include_once 'src/database.php';
            $sql='SELECT DISTINCT guests.guest_id as guest_id , guests.guest_name as guest_name FROM orders LEFT JOIN guests ON orders.guest_id=guests.guest_id WHERE event_id='.$_GET['event_id'].';';
            $result = mysqli_query($link,$sql);
            while($row = $result->fetch_assoc()) {
                echo ("<option value='".$row['guest_id']."'>".$row['guest_name']."</option>");
            }
        ?>
        </select>
            <br>
        <label class="form-label">Payment Type</label>
        <input type="text" id="event_id" name="event_id" value="<?php echo $_GET['event_id'] ?>" hidden> 
        <div class="form-check form-check-inline">
        <input class="form-check-input options" type="checkbox" name="options[]" value="1" checked>
        <label class="form-check-label">Cash</label>
        </div>
        <div class="form-check form-check-inline">
        <input class="form-check-input options" type="checkbox" name="options[]" value="2" checked>
        <label class="form-check-label">Paynow</label>
        </div>
        <div class="form-check form-check-inline">
        <input class="form-check-input options" type="checkbox" name="options[]" value="3" checked>
        <label class="form-check-label">Touch and Go</label>
        </div>
        <div class="form-check form-check-inline">
        <input class="form-check-input options" type="checkbox" name="options[]" value="4" checked>
        <label class="form-check-label">Bank in transfer</label>
        </div>
        <div class="form-check form-check-inline">
        <input class="form-check-input options" type="checkbox" name="options[]" value="5" checked>
        <label class="form-check-label" >Reserve</label>
        </div>
        </div>


        <div class="row">
            <br>
        <?php 

             include_once 'src/database.php';
             $result = mysqli_query($link,"SELECT * FROM events order by event_start_date desc");

             if (mysqli_num_rows($result) > 0) {
            
        ?>

        <!-- <input class='form-control' type="text" id="payment_type_list" onkeyup="searchStaff()" placeholder="Search for payment type..">
        </div> 
        <div class="row">
            <br>
        
        <?php
            //include_once 'src/database.php';
            //$result = mysqli_query($link,"SELECT * FROM payment_types order by payment_type");

            //if (mysqli_num_rows($result) > 0) 
        ?>   -->

        <?php

            include_once 'src/database.php';
            
            $resultEvent = mysqli_query($link,"SELECT event_name FROM events");
            $resultEventsDate = mysqli_query($link,"SELECT event_start_date FROM events order by event_start_date");
            $resultGuests = mysqli_query($link,"SELECT guest_name FROM guests");
            $resultMerchandise = mysqli_query($link,"SELECT merchandise_name FROM merchandises");
            $resultOrderQuantity = mysqli_query($link,"SELECT order_quantity FROM orders");
            $resultOrderPrice = mysqli_query($link,"SELECT order_total_price FROM orders");
            $resultPaymentType = mysqli_query($link,"SELECT payment_type FROM payment_types");

            if (mysqli_num_rows($resultOrderQuantity) > 0) 
            ?>
       
                <table class='table table-bordered table-striped' id="c">
                    
                    <tr class="header">
                        <td><b>Event</td>
                        <td>Date</td>
                        <td>Guest Name</td>
                        <td>Merchandise</td>
                        <td>Quantity</td>
                        <td>Amount</td>
                        <td>Payment Type</b></td>
                    </tr>
                    <tbody id="tbody">  
                    <?php
                    // $limit = 20;

                    while ($row = mysqli_fetch_array($result)) {

                    // $eventFilter = isset($_GET['eventFilter']) ? $_GET['eventFilter'] : '';
                    //$paymentTypeFilter = isset($_GET['paymentTypeFilter']) ? $_GET['paymentTypeFilter'] : '';

                    // $total_rows_query = 'SELECT COUNT(*) as total
                    //                     FROM orders
                    //                     LEFT JOIN events ON orders.event_id = events.event_id
                    //                     LEFT JOIN guests ON orders.guest_id = guests.guest_id
                    //                     LEFT JOIN merchandises ON orders.merchandise_id = merchandises.merchandise_id
                    //                     LEFT JOIN payment_types ON orders.payment_type_id = payment_types.payment_type_id
                    //                     WHERE events.event_name='.$_GET['event_id'].';';
                    //                     //WHERE events.event_name LIKE '%$eventFilter%' AND payment_types.payment_type LIKE '%$paymentTypeFilter%'";
                    // $total_rows_result = mysqli_query($link, $total_rows_query);
                    // $total_rows_data = mysqli_fetch_assoc($total_rows_result);
                    // $total_rows = $total_rows_data['total'];
                

                    // $total_pages = ceil($total_rows / $limit);

                    // if (!isset($_GET['page'])){
                    //     $page_number = 1;
                    // } else {
                    //     $page_number = $_GET['page'];
                    // }

                    // $initial_page = ($page_number - 1) * $limit;

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
                                WHERE events.event_id ='.$_GET['event_id'].' 
                                
                                GROUP BY events.event_name, 
                                        events.event_start_date, 
                                        guests.guest_name, 
                                        merchandises.merchandise_name, 
                                        payment_types.payment_type,
                                        order_no;';
                                // LIMIT " . $initial_page . ',' . $limit';

                    $result = mysqli_query($link, $getQuery);

                    $total_quantity_sum=0;
                    $total_amount_sum=0;

                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row["event_name"]; ?></td>
                            <td><?php echo substr($row['order_no'],2,4)."-".substr($row['order_no'],6,2)."-".substr($row['order_no'],8,2); ?></td>
                            <td><?php echo $row["guest_name"]; ?></td>
                            <td><?php echo $row["merchandise_name"]; ?></td>
                            <td><?php echo $row["total_quantity"]; ?></td>
                            <td><?php echo "$ ".$row["total_amount"]; ?></td>
                            <td><?php echo $row["payment_type"]; ?></td>
                        </tr>
                        
                        <?php
                        $total_quantity_sum += $row["total_quantity"];
                        $total_amount_sum += $row["total_amount"];
                    }}

                    // Display the sum row
                        ?>
                        <tr class="sum-row">
                            <td colspan="4">Total</td>
                            <td><?php echo $total_quantity_sum; ?></td>
                            <td><?php echo "$ ".$total_amount_sum; ?></td>
                            <td></td>
                        </tr>
                        <?php

                    // Create pagination links
                    // echo '<div class="pagination">';
                    // for ($page = 1; $page <= $total_pages; $page++) {
                    //     echo '<a href="#" onclick="goToPage(' . $page . ')" class="pagination-link">' . $page . '</a>';
                    // }
                    // echo '</div>';
                    
                    ?>
                </tbody>
                </table>

                <input type="button" class="btn btn-primary" onclick="window.print()" value="Print Table" />
                <a href="report_list.php"  class="btn btn-primary" role="button" id="cancel" name="cancel">Cancel</a>
                <?php
            }
                else{
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
            }?>
        </div>
        </main>
        <?php include_once("src/htmlfooter.php") ?>
        </body>
        </html>

<?php
include "src/database.php";
?>

<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("report_table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function printpage(){
  
    window.print()
}

function goToPage(pageNumber) {
    var url = window.location.href.split('?')[0];
    var eventFilter = document.getElementById("myInput").value;
    //var paymentTypeFilter = document.getElementById("payment_type_list").value;

    var separator = (url.indexOf('?') !== -1) ? '&' : '?';
    window.location.href = `${url}${separator}page=${pageNumber}&eventFilter=${eventFilter}`;
    //window.location.href = `${url}${separator}page=${pageNumber}&eventFilter=${eventFilter}&paymentTypeFilter=${paymentTypeFilter}`;
}


function searchStaff() {

    var inputPaymentType = document.getElementById("payment_type");
    var paymentTypeFilter = inputPaymentType.value;

    var table = document.getElementById("report_table");
    var tr = table.getElementsByTagName("tr");

    for (var i = 0; i < tr.length; i++) {
        var tdEvent = tr[i].getElementsByTagName("td")[0];
        var tdPaymentType = tr[i].getElementsByTagName("td")[6];

        if (tdPaymentType) {
            var txtValueEvent = tdEvent.textContent || tdEvent.innerText;
            var txtValuePaymentType = tdPaymentType.textContent || tdPaymentType.innerText;

            var paymentTypeMatch = txtValuePaymentType.indexOf(paymentTypeFilter) > -1;

            if (paymentTypeMatch) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function filterSector() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("payment_type");
        filter = input.value;
        table = document.getElementById("report_table");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[2];
          if (td) {
            txtValue = td.innerText;
            if (txtValue.indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      }

      
$('input:checkbox').click(function() {
    var event_id=document.getElementById("event_id").value;
    var guest_id=document.getElementById("guest_id").value;
    var url_event = 'report_option.php?event_id=';
    var url_guest = '&guest_id=';
    var url_str = url_event.concat(event_id,url_guest,guest_id)
$.ajax({
    url: url_str,
    type: "post",
    data: $('.options:checked').serialize(),
    success: function(data) {
    $('#tbody').html(data);
    }
});
});

function guestChange() {
    var event_id=document.getElementById("event_id").value;
    var guest_id=document.getElementById("guest_id").value;
    var url_event = 'report_option.php?event_id=';
    var url_guest = '&guest_id=';
    var url_str = url_event.concat(event_id,url_guest,guest_id)
$.ajax({
    url: url_str,
    type: "post",
    data: $('.options:checked').serialize(),
    success: function(data) {
    $('#tbody').html(data);
    }
});
}


</script>




