<?php
header('Content-Type: application/json');
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT 
            vehicle_id,
            COUNT(*) as total_rentals,
            COUNT(CASE WHEN rental_status = 'completed' THEN 1 END) as total_returns
        FROM rentals
        GROUP BY vehicle_id
        ORDER BY vehicle_id;";

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

