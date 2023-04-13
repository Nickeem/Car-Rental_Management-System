<?php
// establish a database connection
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

// check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the form data
$customer_id = (int) $_POST['customer-id'];
$vehicle_id = (int) $_POST['vehicle-id'];
$license = $_POST['license'];
$license_plate = $_POST['license-plate'];
$rental_rate = $_POST['rental-rate'];

$rental_start_date = strtotime($_POST['rental-start-date']);
$rental_end_date = strtotime($_POST['rental-end-date']);

$day_diff = round(($rental_end_date - $rental_start_date) / (60 * 60 * 24));

$rental_start_date = date('Y-m-d', $rental_start_date);
$rental_end_date = date('Y-m-d', $rental_end_date);


$payment_amount = $day_diff * $rental_rate;

//$additional_charges = ;


/*
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
$stmt->close(); */

// update vehicle record to rented
$update_query = "UPDATE vehicles SET availability = 'rented' WHERE id = $vehicle_id";
$result = mysqli_query($conn, $update_query);
$rental_status = "ongoing";

// Insert rental record into rentals table
$sql = "INSERT INTO rentals (customer_id, vehicle_id, rental_start_date, rental_end_date, rental_rate, payment_amount, rental_status) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssss", $customer_id, $vehicle_id, $rental_start_date, $rental_end_date, $rental_rate, $payment_amount, $rental_status);
$result = $stmt->execute();

if ($_POST['new-damage']) {
    $new_damage = $_POST['new-damage'];
    $update_damge_query = "UPDATE vehicles SET vehicleCondition = $new_damage;";
    $damage_update_result = mysqli_query($conn, $new_damage);
     // Initialize this variable. You can set it using the appropriate form field.
}

if ($result) {
    echo "Rental created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
