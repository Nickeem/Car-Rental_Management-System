<?php
header('Content-Type: application/json');
$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT 
            v.id AS vehicle_id,
            v.make,
            v.model,
            v.year,
            COUNT(*) as total_rentals,
            COUNT(CASE WHEN r.rental_status = 'completed' THEN 1 END) as total_returns
        FROM rentals r
        JOIN vehicles v ON r.vehicle_id = v.id
        GROUP BY v.id, v.make, v.model, v.year
        ORDER BY total_rentals DESC, v.id;";

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
