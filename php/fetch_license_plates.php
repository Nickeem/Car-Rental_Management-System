<?php
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$pattern = $_POST['pattern'];
$return_rented = $_POST['return_rented'];
$availability = "not-rented";
if($return_rented == "true") { // vehicles returned are dependent on form type and whether vehicles are rented or not rented
    $availability = "rented";
}

$query = "SELECT * FROM vehicles WHERE license_plate_number LIKE '%$pattern%' AND availability = '$availability'";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>

