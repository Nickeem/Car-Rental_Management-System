<?php
// establish a database connection
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

// check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$customer_id = (int) $_POST['customer_id'];
$vehicle_id = (int) $_POST['vehicle_id'];

$query = "SELECT * FROM rentals WHERE vehicle_id = $vehicle_id AND customer_id = $customer_id AND rental_status = 'ongoing';";
$result = mysqli_query($conn, $query);

/*if (mysql_num_rows($result) == 0) {
    echo json_encode(array('message'=> "There are no current rentals with the given information", "status" => false));
    return;
} */// not included because code does 

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
