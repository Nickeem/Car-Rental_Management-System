<?php
header('Content-Type: application/json');
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT 
            customer_id,
            vehicle_id,
            rental_start_date,
            rental_end_date,
            actual_return_date,
            TIMESTAMPDIFF(DAY, rental_end_date, actual_return_date) as lateness_duration,
            late_fee
        FROM rentals
        WHERE actual_return_date > rental_end_date AND rental_status = 'completed';";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(array("message" => "No records found."));
}

mysqli_close($conn);
?>

