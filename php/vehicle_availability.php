<?php
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$today = date("Y-m-d");

$sql = "SELECT v.id, v.make, v.model, v.year, v.vin, v.license_plate_number, v.availability, r.rental_start_date, r.rental_end_date
        FROM vehicles AS v
        LEFT JOIN rentals AS r ON v.id = r.vehicle_id
        WHERE v.availability = 'not-rented' OR (r.rental_end_date >= ? AND v.availability = 'rented')
        GROUP BY v.id
        ORDER BY v.id ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($data);

$stmt->close();
$conn->close();
?>


