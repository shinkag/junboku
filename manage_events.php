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
<title>Manage Events</title>
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
    <a href="manage_events_add.php"  class="btn btn-success " role="button" id="add" name="add" >
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Event
    </a>
    </div>
    <div class="row">
    <form action="main_page.php" method="post">
        <div class="row">
            <h1>Event List</h1>
        </div>
        <div class="row">
        <br>
        <input class='form-control' type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for event..">
        </div> 
        <div class="row">
            <br>
        <?php
            include_once 'src/database.php';
            $result = mysqli_query($link,"SELECT * FROM events order by event_start_date desc");
        ?>
 
        <?php
            if (mysqli_num_rows($result) > 0) {
        ?>
       
            <table class='table table-bordered table-striped' id="event_table">
                <tr class="header">
                    <td>Event ID</td>
                    <td>Event Name</td>
                    <td>Start Date</td>
                    <td>End Date</td>
                    <td>Manage Event</td> 
                </tr>
                <?php
                    $i=0;
                    while($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row["event_id"]; ?></td>
                    <td><?php echo $row["event_name"]; ?></td>
                    <td><?php echo $row["event_start_date"]; ?></td>
                    <td><?php echo $row["event_end_date"]; ?></td>
                    <td><a href='manage_events_detail.php?event_id=<?php echo $row["event_id"]; ?> '>Edit</a></td>
                </tr>
                <?php
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
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("event_table");
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


