<?php 
require_once('config.php'); 
session_start();

if(!isset($_SESSION["user_id"])){
  header("location: index.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $input = json_decode(file_get_contents('php://input'), true);
  if(isset($input["task_id"], $input["task_name"], $input["task_due_date"], $input["task_project"], $input["task_status"])) {
    $stmt = $conn->prepare('UPDATE tasks SET task_name = ?, due_date = ?, project_id = ?, user_id = ?, status = ? WHERE id = ?');
    $stmt->bind_param('ssissi', $input["task_name"], $input["task_due_date"], $input["task_project"], $_SESSION["user_id"], $input["task_status"], $input["task_id"]);
    $stmt->execute();
    exit;
  }
}
$stmt = $conn->prepare('SELECT tasks.*, projects.name AS project_name FROM tasks JOIN projects ON tasks.project_id = projects.id WHERE projects.user_id = ?');
$stmt->bind_param('i', $_SESSION["user_id"]);
$stmt->execute();
$tasks_result = $stmt->get_result();
$tasks = $tasks_result->fetch_all(MYSQLI_ASSOC);
$stmt = $conn->prepare('SELECT * FROM projects WHERE user_id = ?');
$stmt->bind_param('i', $_SESSION["user_id"]);
$stmt->execute();
$projects_result = $stmt->get_result();
$projects = $projects_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/logo.css">
  <link rel="stylesheet" href="css/contact-form.css">
  <link rel="stylesheet" href="css/tasks.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="pic/LogoForProject.png" />
  <title>Tasks</title>
</head>
<body>

  <header>
    <nav>
      <a href="projects.php">Projects</a>
      <a href="settings.php">Settings</a>
      <a href="dashboard.php">Dashboard</a>
      <a href="feedback.php">Feedback</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>
  <div class="container">
  <!--<input type="text" id="search" placeholder="Search tasks..."> -->
  <button id="show-add-task-form-btn">Add Task</button>
    <h2>All Tasks</h2>
    <form id="add-task-form" style="display: none;" method="post">
    <label for="task-name">Task Name:</label>
    <input type="text" id="task-name" name="task_name" required>

    <label for="task-due-date">Due Date:</label>
    <input type="date" id="task-due-date" name="task_due_date" required>

    <label for="task-project">Project:</label>
    <select id="task-project" name="task_project" required>
      <?php foreach($projects as $project): ?>
        <option value="<?php echo $project['id']; ?>">
          <?php echo htmlspecialchars($project['name']); ?>
        </option>
      <?php endforeach; ?>
    </select>
    <label for="task-status">Status:</label>
<select id="task-status" name="task_status" required>
  <option value="Not Started">Not Started</option>
  <option value="In Progress">In Progress</option>
  <option value="Completed">Completed</option>
</select>
    <button type="submit">Save</button>
    <button type="button" id="cancel-add-task-btn">Cancel</button>
  </form>
    <table id="tasks-table">
      <thead>
        <tr>
          <th>Task</th>
          <th>Due Date</th>
          <th>Project</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($tasks as $task): ?>
          <tr>
            <td><?php echo htmlspecialchars($task["task_name"]); ?></td>
            <td><?php echo htmlspecialchars($task["due_date"]); ?></td>
            <td><?php echo htmlspecialchars($task["project_name"]); ?></td> 
            <td><?php echo htmlspecialchars($task["status"]); ?></td>
            <td>
            <button class="edit-task" data-id="<?php echo $task['id']; ?>">Edit</button>
            <button class="delete-task" data-id="<?php echo $task['id']; ?>">Delete</button>
            </td>
         </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h2>Edit Task</h2>
<form id="edit-task-form" style="display: none;" method="post">
      <input type="hidden" id="edit-task-id" name="task_id">
      <label for="edit-task-name">Task Name:</label>
    <input type="text" id="edit-task-name" name="task_name" required>
    <label for="edit-task-due-date">Due Date:</label>
      <input type="date" id="edit-task-due-date" name="task_due_date" required>
      <label for="edit-task-status">Status:</label>
  <select id="edit-task-status" name="task_status" required>
    <option value="Not Started">Not Started</option>
    <option value="In Progress">In Progress</option>
    <option value="Completed">Completed</option>
  </select>
  <button type="submit">Save</button>
  <button type="button" id="cancel-edit-task-btn">Cancel</button>
</form>

  </div>
  
  <form id="contact_form" name="contact_form" method="POST">
    <input type="hidden" name="_next" value="https://fsprojecttaskmanagment.000webhostapp.com/tasks.php">
  <div>
    <h1>Contact Us</h1>
  </div>
  <div class="mb-5 row">
    <div class="col">
      <label>Full Name</label>
      <input type="text" required maxlength="50" class="form-control" id="first_name" name="first_name">
    </div>
  </div>
  <div class="mb-5 row">
    <div class="col">
      <label for="email_addr">Email address</label>
      <input type="email" required maxlength="50" class="form-control" id="email_addr" name="email"
        placeholder="name@example.com">
    </div>
    <div class="col">
      <label for="phone_input">Phone</label>
      <input type="tel" required maxlength="50" class="form-control" id="phone_input" name="Phone" placeholder="Phone">
    </div>
  </div>
  <div class="mb-5 row">
    <div class="col">
      <label for="country_select">Where do you live?</label>
      <select class="form-control" id="country_select" name="country">
        <option value="Israel">Israel</option>
        <option value="USA">USA</option>
        <option value="EU">EU</option>
      </select>
    </div>
  </div>
  <div class="mb-5 row">
    <div class="col">
      <label for="password_input">Password</label>
      <input type="password" required maxlength="50" class="form-control" id="password_input" name="password"
        placeholder="Password">
    </div>
    <div class="col">
      <label for="url_input">WebSite</label>
      <input type="url" required maxlength="100" class="form-control" id="url_input" name="url" placeholder="URL">
    </div>
  </div>
  <div class="mb-5 row">
    <div class="col">
      <label for="number_input">Home Phone</label>
      <input type="number" required class="form-control" id="number_input" name="number" placeholder="Number" list="number_options">
      <datalist id="number_options">
        <option value="04"></option>
        <option value="03"></option>
        <option value="02"></option>
        <option value="077"></option>
      </datalist>
    </div>
    <div class="col">
    <label for="range_input">Range (0-100)</label>
    <input type="range" class="form-control" id="range_input" name="range" min="0" max="100">
    </div>
  </div>
  <div class="mb-5 row">
    <div class="col">
      <label for="color_input">Color</label>
      <input type="color" class="form-control" id="color_input" name="color">
    </div>
  </div>
  <div class="mb-5 row">
    <div class="col">
      <label for="date_input">Date</label>
      <input type="date" class="form-control" id="date_input" name="date">
    </div>
    <div class="col">
      <label for="time_input">Time</label>
      <input type="time" class="form-control" id="time_input" name="time">
    </div>
    <div class="col">
      <label for="datetime_input">Datetime</label>
      <input type="datetime-local" class="form-control" id="datetime_input" name="datetime">
    </div>
  </div>
  <div class="mb-5">
    <label for="message">Message</label>
    <textarea class="form-control" id="message" name="message" rows="5"></textarea>
  </div>
  <div class="mb-5">
    <label for="attachment">File Upload</label>
    <input type="file" class="form-control" id="attachment" name="attachment">
  </div>
  <button type="submit" class="btn btn-primary px-4 btn-lg">Post</button>
</form>
 
  <div class="image-bottom">
    <img src="pic/LogoForProject.png" alt="description of your image">
  </div> 
  <script src="js/tasks.js"></script>

</body>
</html>
