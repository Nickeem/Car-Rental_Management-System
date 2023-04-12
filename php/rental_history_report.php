<?php
header('Content-Type: application/json');

$conn = mysqli_connect('localhost', 'root', '', 'rental_system');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT rental_start_date, rental_end_date, rental_rate, payment_amount
            FROM rentals
            WHERE rental_start_date >= ? AND rental_end_date <= ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $row['rental_duration'] = (strtotime($row['rental_end_date']) - strtotime($row['rental_start_date'])) / 86400;
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request. Please provide start_date and end_date.']);
}

$conn->close();
?>

