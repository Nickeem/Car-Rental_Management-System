<?php
// establish a database connection
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

// check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// retrieve data from the form
$make = $_POST['Make'];
$model = $_POST['Model'];
$year = $_POST['year'];
$vin = $_POST['VIN'];
$interior_color = $_POST['interior-color'];
$exterior_color = $_POST['exterior-color'];
$license_plate_number = $_POST['license'];
$odometer_reading = $_POST['odometer'];

// prepare the SQL statement
$sql = "INSERT INTO vehicles (make, model, year, vin, interior_color, exterior_color, license_plate_number, odometer_reading) VALUES ('$make', '$model', '$year', '$vin', '$interior_color', '$exterior_color', '$license_plate_number', '$odometer_reading')";

// execute the SQL statement
if (mysqli_query($conn, $sql)) {
    echo json_encode(array('success'=> "true"));
} else {
    echo json_encode(array('success'=> "false"));;
}

// close the database connection
mysqli_close($conn);
?>

