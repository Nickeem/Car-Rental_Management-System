<?php
//for generating customer rental history report
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// establish a database connection
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

// check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Get the customer's driver's license number from the request
$license = $_POST['license'];

// Query the database for the customer rental history
$sql = "SELECT rentals.id, rentals.rental_start_date, rentals.rental_end_date, rentals.rental_rate, rentals.additional_charges, vehicles.make, vehicles.model
        FROM rentals
        INNER JOIN customers ON rentals.customer_id = customers.id
        INNER JOIN vehicles ON rentals.vehicle_id = vehicles.id
        WHERE customers.driver_license_number = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $license);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Return the data as JSON
echo json_encode($data);

// Close the connection
$conn->close();
?>

