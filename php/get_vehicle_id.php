<?php
// establish a database connection
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

// check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$license_plate = $_POST['pattern'];

$query = "SELECT id FROM vehicles WHERE license_plate_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $license_plate);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['id' => $row['id']]);
} else {
    echo json_encode(['id' => -1]);
}

$stmt->close();
$conn->close();
?>

