<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

set_error_handler(function($errno, $errstr, $errfile, $errline ) {
    echo json_encode(['success' => false, 'message' => "$errstr in $errfile on line $errline"]);
    die();
});

require_once('config.php');
session_start();
header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id']; // get the id from the request body
    $allowed_fields = ['task_name', 'due_date', 'task_project', 'status'];
    foreach ($input as $field => $value) {
        if (in_array($field, $allowed_fields)) {
            $sql = "UPDATE tasks SET $field = ? WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sis', $value, $id, $_SESSION['user_id']);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $success = true;
            } else {
                $success = false;
            }
        }
    }
    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Could not find task or no updates were made']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
