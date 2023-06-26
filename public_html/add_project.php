<?php 
require_once('config.php'); 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = trim(filter_input(INPUT_POST, 'project-name', FILTER_SANITIZE_STRING));
    $project_description = trim(filter_input(INPUT_POST, 'project-description', FILTER_SANITIZE_STRING));
    $project_status = trim(filter_input(INPUT_POST, 'project-status', FILTER_SANITIZE_STRING));
    $user_id = $_SESSION["user_id"];

    // Check if project name or description are empty
    if(empty($project_name) || empty($project_description)) {
        $_SESSION['error_message'] = "Project name and description can't be empty";
    } else {
        // Check if a project with the same name already exists
        $stmt = $conn->prepare('SELECT * FROM projects WHERE name = ? AND user_id = ?');
        $stmt->bind_param('si', $project_name, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $_SESSION['error_message'] = "A project with the same name already exists.";
        } else {
            // Insert the new project
            $stmt = $conn->prepare('INSERT INTO projects (name, user_id, description, status) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('siss', $project_name, $user_id, $project_description, $project_status);

            if ($stmt->execute()) {
                header('Location: projects.php');
                exit();
            } else {
                $_SESSION['error_message'] = "There was an error adding the project";
            }
        }
    }

    if(isset($_SESSION['error_message'])) {
        // Redirect back to the form with the error message
        header('Location: projects.php');
        exit();
    }
}
?>
