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
<title>Manage Guest</title>
</head>
<body>
<main>
<div class="container">
    <div class="jumbotron text-center">
        <img src="img/jcos_logo.jpg" class="img-rounded">
        <h1> Junboku Event</h1> 
        <h1>Sales Tracker System</h1>
        <h2> Guest Management</h2>
    </div>

    <?php if(isset($_SESSION["staff_id"])){ 
           
    ?>


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
    <a href="manage_guests_add.php"  class="btn btn-success" role="button" id="add" name="add">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Guest
    </a>
    </div>

    <div class="row">
    <form action="main_page.php" method="post" style="margin-top:50px, margin-left:100px">
        <div class="row">
            <h1>Guest List</h1>
        </div>
        <div class="row">
        <br>
        <input class='form-control' type="text" id="staff_list" onkeyup="searchStaff()" placeholder="Search for guest..">
        </div> 
        <div class="row">
            <br>
        <?php
            include_once 'src/database.php';
            $result = mysqli_query($link,"SELECT * FROM guests order by guest_id ASC");
        ?>
 
        <?php
            if (mysqli_num_rows($result) > 0) {
        ?>
       
            <table class='table table-bordered table-striped' id="staff_table">
                <tr class="header">
                    <td>Guest ID</td>
                    <td>Guest Name</td>
                    <td>Guest Email</td>
                    <td>Guest contact</td>
                    <td>Guest Country</td>
                    <td>Edit Guest</td> 
                </tr>
                <?php
                    $i=0;
                    while($row = mysqli_fetch_array($result)) {
                
                    echo '<tr>';
                    echo '<td>'.$row["guest_id"].'</td>';
                    echo '<td>'.$row["guest_name"].'</td>';
                    echo '<td>'.$row["guest_email"].'</td>';
                    echo '<td>'.$row["guest_contact"].'</td>';
                    echo '<td>'.$row["guest_country"].'</td>';
                    echo '<td><a href="manage_guests_detail.php?guest_id='.$row['guest_id'].'&guest_name='.$row['guest_name'].'&staff_id='.$_SESSION['staff_id'].'">View</a></td>';
                    echo '</tr>';
                    $i++;
                    }
                ?>
            </table>
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
function searchStaff() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("staff_list");
  filter = input.value.toUpperCase();
  table = document.getElementById("staff_table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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
</script>