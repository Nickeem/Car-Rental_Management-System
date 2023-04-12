<?php
// establish a database connection
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

// check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$license = $_POST['license'];
$limit = 5;

$query = "SELECT * FROM customers WHERE driver_license_number = '$license'";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
