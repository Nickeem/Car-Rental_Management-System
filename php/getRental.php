<?php
// establish a database connection
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

// check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$customer_id = (int) $_POST['customer_id'];
$vehicle_id = (int) $_POST['vehicle_id'];

$query = "SELECT * FROM rentals WHERE vehicle_id = $vehicle_id AND customer_id = $customer_id;";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
