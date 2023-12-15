<?php
if (ISSET($_POST)) {
    $ref = $_POST['mer_id'];

    include_once 'src/database.php';
    $query_latest_po='SELECT * FROM merchandises WHERE merchandise_id ='.$ref.' LIMIT 1';
    $result = mysqli_query($link,$query_latest_po);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
        $merhandise_name=$row['merchandise_name'];
        $merhandise_price=$row['merchandise_price'];
        $merchandise_barcode_no=$row['merchandise_barcode_no'];
        
        }
    }

    $json = array('mer_name' => $merhandise_name, 'mer_price' => $merhandise_price, 'mer_barcode'=> $merchandise_barcode_no);
    echo json_encode($json);
}
?>