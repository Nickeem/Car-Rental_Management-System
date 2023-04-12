<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$license_plate = $_POST['license_plate'];

$sql = "SELECT rentals.id, rentals.rental_start_date, rentals.rental_end_date, rentals.rental_rate, rentals.additional_charges, customers.first_name, customers.last_name
        FROM rentals
        INNER JOIN customers ON rentals.customer_id = customers.id
        INNER JOIN vehicles ON rentals.vehicle_id = vehicles.id
        WHERE vehicles.license_plate_number = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $license_plate);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>

