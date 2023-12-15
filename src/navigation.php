<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><b><?php echo $_SESSION['staff_name'];?></b></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a class="nav-link active" aria-current="page" href="#">Order Form</a></li> -->
        <li><a class="nav-link" href="main_page.php">Event List</a></li>
        <li><a class="nav-link" href="report_list.php">View Report</a></li>
<?php  $position=$_SESSION['staff_position'];
        if($position=="manager"){
?>

        <li><a class="nav-link" href="manage_staffs.php">Manage Staff</a></li>
        <li><a class="nav-link" href="manage_events.php">Manage Event</a></li>
        <li><a class="nav-link" href="manage_guests.php">Manage Guest</a></li>
<?php } ?>
        <li><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
