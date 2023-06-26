<?php
session_start();
require_once('config.php');
header('Content-Type: application/json');

if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Check if task exists and belongs to the current user
    $sql = "SELECT * FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $_GET['id'], $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $_GET['id'], $userId);
        $stmt->execute();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Task does not exist']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User is not logged in']);
}
?>
