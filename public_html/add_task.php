<?php
require_once('config.php');
session_start();
header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $status = $input['status'] ?? 'Incomplete'; 
    $sql = "SELECT * FROM projects WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $input['project_id'], $_SESSION['user_id']);
    $stmt->execute();
    $project = $stmt->get_result()->fetch_assoc();
    if ($project) {
        $sql = "INSERT INTO tasks (task_name, due_date, project_id, user_id, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiss', $input['task_name'], $input['due_date'], $input['project_id'], $_SESSION['user_id'], $status); // use $status variable here
        $stmt->execute();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Project does not exist']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>
