<?php 
require_once('config.php'); 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_id = $_POST['project_id'];

    $stmt = $conn->prepare('DELETE FROM projects WHERE id = ?');
    $stmt->bind_param('i', $project_id);

    if ($stmt->execute()) {
        // The project was successfully deleted
    } else {
        // There was an error deleting the project
    }
}
?>
