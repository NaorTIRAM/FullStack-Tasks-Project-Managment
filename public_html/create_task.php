<?php 
require_once('config.php'); 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = trim(filter_input(INPUT_POST, 'task-name', FILTER_SANITIZE_STRING));
    $due_date = trim(filter_input(INPUT_POST, 'due-date', FILTER_SANITIZE_STRING));
    $project_name = trim(filter_input(INPUT_POST, 'project-name', FILTER_SANITIZE_STRING));
    $status = 'Incomplete';
    $user_id = $_SESSION["user_id"];

    // Check if task name, due date, or project name are empty
    if(empty($task_name) || empty($due_date) || empty($project_name)) {
        $error_message = "Task name, due date, and project name can't be empty";
    } else {
        // Check if a project with the given name exists
        $stmt = $conn->prepare('SELECT * FROM projects WHERE name = ? AND user_id = ?');
        $stmt->bind_param('si', $project_name, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 0) {
            $error_message = "A project with the given name doesn't exist.";
        } else {
            // Get the project's ID
            $project = $result->fetch_assoc();
            $project_id = $project['id'];

            // Insert the new task
            $stmt = $conn->prepare('INSERT INTO tasks (name, due_date, project_id, status) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssis', $task_name, $due_date, $project_id, $status);

            if ($stmt->execute()) {
                header('Location: tasks.php');
                exit();
            } else {
                $error_message = "There was an error adding the task";
            }
        }
    }

    if(isset($error_message)) {
        // Handle the error message (e.g., display it to the user)
    }
}
?>
