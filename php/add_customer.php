<?php
// establish a database connection
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

// check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// retrieve data from the form
$name = $_POST['first-name'] . ' ' . $_POST['last-name'];
$address = $_POST['address'];
$email = $_POST['email-address'];
$phone_number = $_POST['phone-number'];
$driver_license_number = $_POST['license'];
$parish = $_POST['parish'];
$district = $_POST['district'];
$driver_license_expiry_date = $_POST['expiry'];
$credit_card_number = $_POST['card-number'];
$billing_address = $_POST['billing-address'];
$billing_expiry_date = $_POST['card-expiry'];

// prepare the SQL statement
$sql = "INSERT INTO customers (name, address, email, phone_number, driver_license_number, parish, district, driver_license_expiry_date, credit_card_number, billing_address, billing_expiry_date) VALUES ('$name', '$address', '$email', '$phone_number', '$driver_license_number', '$parish', '$district', '$driver_license_expiry_date', '$credit_card_number', '$billing_address', '$billing_expiry_date')";

// execute the SQL statement
if (mysqli_query($conn, $sql)) {
    echo "New customer record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// close the database connection
mysqli_close($conn);
?>


