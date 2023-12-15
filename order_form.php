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
        <h2>Order Form</h2>
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



    <form action="order_form.php?event_id=<?php echo $_GET['event_id'] ?>" method="post" >
        <br>
        
        <?php
                include_once 'src/database.php';
                $query_latest_po='SELECT order_id FROM orders ORDER BY order_id desc LIMIT 1';
                $result = mysqli_query($link,$query_latest_po);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                    $last_order_id=$row['order_id'];
                    }
                }
        
        
                $nextPoNumber = 'PO'.date('Ymd').'-'.sprintf("%04d",$last_order_id+1);
                echo '<h2>
                    Order number: '.$nextPoNumber.'
                </h2><br>';
                $query='SELECT * FROM events WHERE event_id='.$_GET['event_id'].'';
                $result = mysqli_query($link,$query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $event_id=$row['event_id'];
                        $event_name=$row['event_name'];
                        $event_location=$row['event_location'];
                    }
                 }
                echo '';
              
?>      
        <table>
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

        <br>
        <br> 

        <br>
        <div class="controls">
           <table class='table table-bordered table-striped' id="mer_table">
            <tr class="header">
                <td>Merchandise</td>
                <td>Unit</td>
                <td>Remove</td>
            </tr>
        
        <tbody id="tItem">
        </tbody>
        
        </table>
        <input type="button" class="btn btn-success" onclick=addItem() value="Add Item"></input> 
        <br>
        <br>
       
        <div class="row">
        <div class="col-md-3">
        <label for="payment-type" class="form-label">Payment Type:</label>
            <select id="payment-type" name="payment-type" class="form-control">
                <option value=1> Cash </option>
                <option value=2> Paynow </option>
                <option value=3> Touch and Go </option>
                <option value=4> Bank in Transfer </option>
                <option value=5> Reserve </option>
            </select>
            <br>
        </div>
        </div>
        <div class="row">
        <button type="submit" class="btn btn-primary" id="order" name="order">Submit</button>
        <a href="main_page.php"  class="btn btn-primary" role="button" id="cancel" name="cancel">Cancel</a>
        </div>
        <br>
        </div>
    </form>

    <template id="item-template">
        <tr>
        <td>
            <select  name="merid[]" class="form-control mer-item">
            <option value=""></option>
            <?php
                include_once "src/database.php";
                $sql='SELECT * FROM merchandises LEFT JOIN guests ON merchandises.guest_id=guests.guest_id WHERE event_id='.$_GET['event_id'].';';
                $result = mysqli_query($link,$sql);
                while($row = $result->fetch_assoc()) {
                    echo ("<option value='".$row['merchandise_id']."'>".$row['guest_name'].' - '. $row['merchandise_name']."</option>");
                }
            ?>
            </select>
            </td>
        <td><input type="number" class="form-control qty" name="mer_qty[]"   aria-label="0" required ></td>
    
        <td>
        <button type="button" class="btn btn-danger remove">    
        <span class="glyphicon glyphicon-minus"></span>
        </button>
        </td>
        </tr>
        </template>

<?php 
if(isset($_POST['merid'])){
    include_once "src/database.php";

        for ($a = 0; $a < count($_POST["merid"]); $a++){
            $mer_sql='SELECT * FROM merchandises WHERE merchandise_id='.$_POST['merid'][$a].';';
            $mer_result=mysqli_query($link,$mer_sql);
            while($row = $mer_result->fetch_assoc()) {
                $guest_id=$row['guest_id'];
                $mer_price=$row['merchandise_price'];
                $mer_quantity=$row['merchandise_quantity'];
            }
            $total_price = $mer_price*$_POST['mer_qty'][$a];
            $insert_sql='INSERT INTO orders (staff_id,event_id,guest_id,merchandise_id,payment_type_id,order_no,order_quantity,order_total_price,po_number,status) VALUES (
                "'.$_SESSION['staff_id'].'",
                '.$_GET['event_id'].',
                '.$guest_id.',
                '.$_POST['merid'][$a].',
                '.$_POST['payment-type'].',
                "'.$nextPoNumber.'",
                '.$_POST['mer_qty'][$a].',
                '.$total_price .',
                "'.$nextPoNumber.'",
                "pending");';
            //echo $insert_sql;
            mysqli_query($link,$insert_sql);
       }

    echo '<script>window.location.href="order_confirm.php?po='.$nextPoNumber.'&event_id='.$_GET['event_id'].'";</script>';
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

<script>
const template=document.getElementById('item-template');
const tbody=document.getElementById('tItem');
function addItem(){
  	const newRow = template.content.cloneNode(true);
    const firstTd = newRow.querySelector('td:first-child');
    tbody.appendChild(newRow);
}


$(document).ready(function () { 
      // Denotes total number of rows 
      var rowIdx = 0; 
      // jQuery button click event to remove a row. 
      $('#tItem').on('click', '.remove', function () { 
        // Getting all the rows next to the row 
        // containing the clicked button 
        var child = $(this).closest('tr').nextAll(); 
        // Iterating across all the rows  
        // obtained to change the index 
        child.each(function () { 
          // Getting <tr> id. 
          var id = $(this).attr('id'); 
          // Getting the <p> inside the .row-index class. 
          var idx = $(this).children('.row-index').children('p'); 
          // Gets the row number from <tr> id. 
          var dig = parseInt(id.substring(1)); 
          // Modifying row index. 
          idx.html(`Row ${dig - 1}`); 
  
          // Modifying row id. 
          $(this).attr('id', `R${dig - 1}`); 
        }); 
  
        // Removing the current row. 
        $(this).closest('tr').remove(); 
  
        // Decreasing total number of rows by 1. 
        rowIdx--; 
      }); 
    }); 


</script>
