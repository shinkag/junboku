<?php 
session_start(); 
include_once("src/htmlheader.php")
?>

<title>Manage Event</title>
</head>
<body>
<main>
<div class="container">
    <div class="jumbotron text-center">
        <img src="img/jcos_logo.jpg" class="img-rounded">
        <h1> Junboku Event</h1> 
        <h1>Sales Tracker System</h1>
        <h2>Event Management</h2>
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
    <form action="manage_events_add.php" method="post">
        <div class="row">
            <h1>New Event</h1>
        </div>
        <br>

        <div class="row">
            
            <label for="event_id" class="form-label">Event ID</label>
            <input type="text" class="form-control" id="event_id" name="event_id" disabled  placeholder="Auto Generate">
            <br>
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="event_name" name="event_name"  required>
            <br>
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location"  required>
            <br>
        
                <div class="col-l">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"  required>
                </div>
                <br>
                <div class="col-l">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"  required>
                </div>
           
            <br>
        </div>

        
        <div class="control-group">    
        <div class="controls">
        <input type="button" class="btn btn-success" onclick=addGuest() value="Add Guest"></input> 
        <table class='table table-bordered table-striped' id="guest_table">
        <tr class="header">
                    <td>Guest</td>
                    <td>Remove</td>
                </tr>
        <tbody id="tbody">
        </tbody>
        </table>
        <br>
        
        </div>
        <input type="button" class="btn btn-success" onclick=addMerchant() value="Add Merchant"></input> 
    <table class='table table-bordered table-striped' id="mer_table">
    <tr class="header">
        <td>Guest</td>
        <td>Merchandise Name</td>
        <td>Merchandise Quantity</td>
        <td>Merchandise Price $ </td>
        <td>Merchandise Serial</td>
        <td>Remove</td>
    </tr>
    <tbody id="mer_table">
    </tbody>
    </table>
    </div>

        <br>
        <div class="row">
        <button type="submit" class="btn btn-primary" id="add" name="add">Add Event</button>
        <a href="manage_events.php"  class="btn btn-primary" role="button" id="cancel" name="cancel">Cancel</a>
        </div>
        <br>
        <br>     
       
        </div>
    </form>
    </div>

    <template id="row-template">
        <tr>
        <td>
            <select  name="guest_id[]" class="form-control gid">
            <option value=""></option>
            <?php
                include_once "src/database.php";
                $sql="SELECT guest_id, guest_name FROM guests;";
                $result = mysqli_query($link,$sql);
                while($row = $result->fetch_assoc()) {
                    echo ("<option value='".$row['guest_id']."'>".$row['guest_name']."</option>"); 
                }
            ?>
            </select>
            </td>
        <td>
        <button type="button" class="btn btn-danger remove">    
        <span class="glyphicon glyphicon-minus"></span>
        </button>
        </td>
        </tr>
        </template>

    <template id="mer-template">
        <tr>
        <td>
            <select  name="mer_guest[]" class="form-control gid">
            <option value=""></option>
            <?php
                include_once "src/database.php";
                $sql="SELECT guest_id, guest_name FROM guests;";
                $result = mysqli_query($link,$sql);
                while($row = $result->fetch_assoc()) {
                    echo ("<option value='".$row['guest_id']."'>".$row['guest_name']."</option>"); 
                }
            ?>
            </select>
            </td>
        <td> <input type="text" class="form-control" name="mer_name[]"  aria-label="merchant name..." required> </td>
        <td> <input type="number" class="form-control" name="mer_qty[]"   aria-label="0" required > </td>
        <td> <input type="number" min="0.00" max="10000.00" step="0.01" class="form-control" name="mer_price[]"  aria-label="0.00"  required > </td>
        <td> <input type="text" class="form-control" name="mer_serial[]"   aria-label="Use Barcode reader"  required onkeypress="return (event.charCode > 47 && event.charCode < 58)"> </td>
        <td>
        <button type="button" class="btn btn-danger remove_mer">    
        <span class="glyphicon glyphicon-minus"></span>
        </button>
        </td>
        </tr>
    </template>
        
<?php 

if(isset($_POST['event_name'])){
    include_once "src/database.php";

    $query1='INSERT INTO events (staff_id, event_name, event_start_date, event_end_date, event_status,event_location) values("'.$_SESSION["staff_id"].'","'.$_POST['event_name'].'","'.$_POST['start_date'].'","'.$_POST['end_date'].'","1","'.$_POST['location'].'")';
    mysqli_query($link,$query1);
    
    $sql = 'SELECT event_id FROM events ORDER by event_id desc limit 1;';
    $result = mysqli_query($link,$sql);
    while($row = $result->fetch_assoc()) {
        $latest_event_id = $row['event_id'];
    }
    for ($a = 0; $a < count($_POST["guest_id"]); $a++)
    {
        $query2='INSERT INTO attends (event_id,guest_id) VALUES ("'.$latest_event_id.'","'.$_POST["guest_id"][$a].'");';
        mysqli_query($link,$query2);
    }
    
    for($b = 0; $b < count($_POST["mer_guest"]); $b++)
    {
        $query_mer=' 
        INSERT INTO merchandises 
        (event_id, guest_id, staff_id, merchandise_name, merchandise_quantity, merchandise_price, merchandise_barcode_no)  
        VALUES (
            '.$latest_event_id.', 
            '.$_POST['mer_guest'][$b].',
            "'.$_SESSION['staff_id'].'",
            "'.$_POST['mer_name'][$b].'",
            '.$_POST['mer_qty'][$b].',
            '.$_POST['mer_price'][$b].',
            "'.$_POST['mer_serial'][$b].'"
        );';

        echo mysqli_query($link,$query_mer);

    }
 
    
    echo "<script>window.location.href='manage_events.php';</script>";
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

const template=document.getElementById('row-template');
const tbody=document.getElementById('tbody');
function addGuest(){
  	const newRow = template.content.cloneNode(true);
    const firstTd = newRow.querySelector('td:first-child');
    tbody.appendChild(newRow);
}

const template2=document.getElementById('mer-template');
const tbody2=document.getElementById('mer_table');
function addMerchant(){
  	const newRow = template2.content.cloneNode(true);
    const firstTd = newRow.querySelector('td:first-child');
    tbody2.appendChild(newRow);
}

$(document).ready(function () { 
      // Denotes total number of rows 
      var rowIdx = 0; 

      // jQuery button click event to remove a row. 
      $('#tbody').on('click', '.remove', function () { 
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

$(document).ready(function () { 
      // Denotes total number of rows 
      var rowIdx = 0; 

      // jQuery button click event to remove a row. 
      $('#mer_table').on('click', '.remove_mer', function () { 
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


// window.onload = function() {
//     // var input = document.getElementById("barcode").focus();
//     var x = document.getElementsByName("mer_serial"); 
//     document.getElementsByName("mer_serial").innerHTML = x.focus().value;  
// }
$(":input").keypress(function(event){
    if (event.which == '10' || event.which == '13') {
        event.preventDefault();
    }
});


</script>