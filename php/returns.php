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

$actual_return_date = $_POST['actual-return-date'];
$actual_return_date = strtotime($actual_return_date);
$actual_return_date = date('Y-m-d', $actual_return_date);


$late_fee = $_POST['late-fee'];
$additional_charges = $_POST['additional-fees'];
$vehicle_condition = $_POST['new-damage']; // Initialize this variable. You can set it using the appropriate form field.


// update vehicle record to rented
$update_query = "UPDATE vehicles SET availability = 'not-rented' WHERE id = $vehicle_id;";
$result = mysqli_query($conn, $update_query);



// Insert rental record into rentals table
$return_query = "UPDATE rentals SET actual_return_date = '$actual_return_date', late_fee = $late_fee, additional_charges = $additional_charges, rental_status = 'completed' WHERE vehicle_id = $vehicle_id AND customer_id = $customer_id;";
$return_result = mysqli_query($conn, $return_query);

if($_POST['new-damage'] != '') {
    $new_damage = $_POST['new-damage'];
    $update_damage = "UPDATE vehicles SET vehicle_damage = $new_damage WHERE id = $vehicle_id;";
     //update vehicle damage in rentals table - should be a field for damage before and damage after

}


if ($return_result) {
    echo "Return recorded successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
