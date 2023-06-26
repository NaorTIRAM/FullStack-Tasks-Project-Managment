<?php 
require_once('config.php'); 
session_start();

if(!isset($_SESSION["user_id"])){
  header("location: index.php");
  exit;
}

$stmt = $conn->prepare('SELECT * FROM projects WHERE user_id = ?');
$stmt->bind_param('i', $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/projects.css">
  <link rel="stylesheet" href="css/logo.css">
  <link rel="stylesheet" href="css/contact-form.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="pic/LogoForProject.png" />

  <title>Projects</title>
  <style>
    form#add-project-form {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin: auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
      background-color: #fff;
      width: 50%; 
      max-width: 500px; 
    }

    form#add-project-form label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
    }

    form#add-project-form input[type="text"], form#add-project-form textarea, form#add-project-form select {
      display: block;
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-bottom: 20px;
    }

    form#add-project-form input[type="submit"] {
      display: inline-block;
      background-color: #007bff;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    form#add-project-form input[type="submit"]:hover {
      background-color: #0056b3;
    }

    #projects-list {
      list-style-type: none;
      padding: 0;
    }

    #projects-list li {
      background-color: #fff;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 3px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #projects-list li h2 {
      font-size: 18px;
      margin: 0;
    }

    #projects-list li button:hover {
      background-color: #c82333;
    }
    h1{
      font-family: "Times New Roman";
      color: #020e1b;
    }
  </style>
</head>
<body>
  <header>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="tasks.php">Tasks</a>
      <a href="settings.php">Settings</a>
      <a href="feedback.php">Feedback</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>
  <div class="project-ideas">
<h2>You can use explore <a href="https://www.interregeurope.eu/project-ideas">Projects Ideas </a></h2>
  </div>

  <div class="container">
  <?php if(isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
      <?php 
      echo $_SESSION['error_message']; 
      unset($_SESSION['error_message']);
      ?>
    </div>
  <?php endif; ?>
</div>
  <form id="add-project-form" method="post" action="add_project.php">
  <label for="project-name">Project Name:</label><br>
  <input type="text" id="project-name" name="project-name" required><br>
  <label for="project-description">Project Description:</label><br>
  <textarea id="project-description" name="project-description" required></textarea><br>
  <label for="project-status">Project Status:</label><br>
  <select id="project-status" name="project-status" required>
    <option value="">Please select a status</option>
    <option value="Not Started">Not Started</option>
    <option value="In Progress">In Progress</option>
    <option value="Complete">Complete</option>
  </select><br>
  <input type="submit" value="Add Project" id="add-project-btn">
</form>
<ul id="projects-list">
  <?php foreach($projects as $project): ?>
    <li>
      <div>
        <h2>Project Name</h2>
        <p><?php echo htmlspecialchars($project["name"]); ?></p>
      </div>
      <div>
        <h2>Description</h2>
        <p><?php echo htmlspecialchars($project["Description"]); ?></p>
      </div>
      <div>
        <h2>Status</h2>
        <p><?php echo htmlspecialchars($project["Status"]); ?></p>
        <select class="status-select" data-projectid="<?php echo $project['id']; ?>">
          <option value="Not Started" <?php echo $project["Status"] == 'Not Started' ? 'selected' : ''; ?>>Not Started</option>
          <option value="In Progress" <?php echo $project["Status"] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
          <option value="Complete" <?php echo $project["Status"] == 'Complete' ? 'selected' : ''; ?>>Complete</option>
        </select>
      </div>
      <button class="delete-btn" data-projectid="<?php echo $project['id']; ?>">Delete</button>
    </li>
  <?php endforeach; ?>
</ul>
<form id="contact_form" name="contact_form" method="POST">
    <input type="hidden" name="_next" value="https://fsprojecttaskmanagment.000webhostapp.com/projects.php">
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


  <script src="js/projects.js"></script>

</body>
</html>
