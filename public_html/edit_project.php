<?php 
require_once('config.php'); 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_id = $_POST['project_id'];
    $project_name = trim(filter_input(INPUT_POST, 'project-name', FILTER_SANITIZE_STRING));
    $project_description = trim(filter_input(INPUT_POST, 'project-description', FILTER_SANITIZE_STRING));
    $project_status = trim(filter_input(INPUT_POST, 'project-status', FILTER_SANITIZE_STRING));

    $stmt = $conn->prepare('UPDATE projects SET name = ?, description = ?, status = ? WHERE id = ?');
    $stmt->bind_param('sssi', $project_name, $project_description, $project_status, $project_id);

    if ($stmt->execute()) {
        // The project was successfully updated
    } else {
        // There was an error updating the project
    }
}
?>
