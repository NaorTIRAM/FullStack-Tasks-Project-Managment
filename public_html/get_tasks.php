<?php
require_once('config.php');
session_start();

header('Content-Type: application/json');

$sql = "SELECT tasks.*, projects.name AS project_name FROM tasks JOIN projects ON tasks.project_id = projects.id WHERE tasks.user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll();

echo json_encode($tasks);
?>
