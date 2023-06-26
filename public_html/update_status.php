<?php
require_once('config.php'); 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $project_id = $data['project_id'];
    $status = $data['status'];

    $stmt = $conn->prepare('UPDATE projects SET status = ? WHERE id = ?');
    $stmt->bind_param('si', $status, $project_id);

    if ($stmt->execute()) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}
?>
