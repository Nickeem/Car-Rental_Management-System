<?php
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$license_plate = $_POST['license_plate'];

$query = "SELECT * FROM vehicles WHERE license_plate_number LIKE '$license_plate%'";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
