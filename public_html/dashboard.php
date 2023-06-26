<?php 
require_once('config.php'); 
session_start();
// Check if the user is not logged in, if yes then redirect him to login page
if(!isset($_SESSION["user_id"])){
  header("location: index.php");
  exit;
}

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query for active projects
$activeProjectsQuery = "SELECT COUNT(*) as count FROM projects WHERE user_id = ".$_SESSION['user_id']." AND Status='In progress'";
$result = $conn->query($activeProjectsQuery);
$row = $result->fetch_assoc();
$activeProjects = $row['count'];

// Query for completed tasks
$completedTasksQuery = "SELECT COUNT(*) as count FROM tasks WHERE user_id = ".$_SESSION['user_id']." AND status='completed'";
$result = $conn->query($completedTasksQuery);
$row = $result->fetch_assoc();
$completedTasks = $row['count'];

// Query for upcoming deadlines (assuming tasks with due date within next 7 days)
$upcomingDeadlinesQuery = "SELECT COUNT(*) as count FROM tasks WHERE user_id = ".$_SESSION['user_id']." AND due_date >= CURDATE() AND due_date < CURDATE() + INTERVAL 7 DAY";
$result = $conn->query($upcomingDeadlinesQuery);
$row = $result->fetch_assoc();
$upcomingDeadlines = $row['count'];

$conn->close();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_POST['first_name'];
  $email = $_POST['email'];
  $phone = $_POST['Phone'];
  $message = $_POST['message'];

  // Create the email and send the message
  //$to = 'somemail@walla.co.il'; // where you want to send the email
  //$email_subject = "Contact form submitted by:  $name";
  //$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nPhone: $phone\n\nMessage:\n$message";
  //$headers = "From: noreply@yourdomain.com\n";
  //$headers .= "Reply-To: $email";
  //mail($to,$email_subject,$email_body,$headers); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="stylesheet" href="css/logo.css">
  <link rel="shortcut icon" type="image/x-icon" href="pic/LogoForProject.png" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/contact-form.css">
  <title>Dashboard</title>
</head>
<body>
  <header>
    <nav>
      <a href="tasks.php">Tasks</a>
      <a href="projects.php">Projects</a>
      <a href="settings.php">Settings</a>
      <a href="feedback.php">Feedback</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>
  <div class="google-calendar-card">
      <h2>You can use <a href="https://workspace.google.com/products/calendar/?hl=iw">Google Calendar</a> if needed</h2>
  </div>
  <div class="container">
  <div class="card">
    <h2>Active Projects</h2>
    <p><?php echo $activeProjects; ?></p>
  </div>
  <div class="card">
    <h2>Completed Tasks</h2>
    <p><?php echo $completedTasks; ?></p>
  </div>
  <div class="card">
    <h2>Upcoming Deadlines</h2>
    <p><?php echo $upcomingDeadlines; ?></p>
  </div>
</div>
<form id="contact_form" name="contact_form" method="POST">
    <input type="hidden" name="_next" value="https://fsprojecttaskmanagment.000webhostapp.com/dashboard.php">
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

  <script src="js/script.js"></script>
</body>
</html>
