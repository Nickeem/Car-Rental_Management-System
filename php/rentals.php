<?php
// establish a database connection
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

// check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the form data
$license = $_POST['license'];
$license_plate = $_POST['license-plate'];
$rental_start_date = $_POST['rental-start'];
$rental_end_date = $_POST['rental-end'];
$rental_rate = $_POST['rental-rate'];
$additional_charges = $_POST['additional-fees'];
$vehicle_condition = ""; // Initialize this variable. You can set it using the appropriate form field.


// Get customer_id using the license
$sql = "SELECT id FROM customers WHERE driver_license_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $license);
$stmt->execute();
$stmt->bind_result($customer_id);
$stmt->fetch();
$stmt->close();

// Get vehicle_id using the license_plate
$sql = "SELECT id FROM vehicles WHERE license_plate_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $license_plate);
$stmt->execute();
$stmt->bind_result($vehicle_id);
$stmt->fetch();
$stmt->close();

// Insert rental record into rentals table
$sql = "INSERT INTO rentals (customer_id, vehicle_id, rental_start_date, rental_end_date, rental_rate, additional_charges, vehicle_condition) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssss", $customer_id, $vehicle_id, $rental_start_date, $rental_end_date, $rental_rate, $additional_charges, $vehicle_condition);
$result = $stmt->execute();

if ($result) {
    echo "Rental created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
