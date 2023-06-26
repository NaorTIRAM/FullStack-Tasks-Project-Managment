<?php
require_once('config.php');
session_start();

if(!isset($_SESSION["user_id"])){
  header("location: index.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = trim(filter_input(INPUT_POST, 'old_password', FILTER_SANITIZE_STRING));
    $new_password = password_hash(trim(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING)), PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);

    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($old_password, $user['password'])) {
      $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
      $stmt->bind_param('si', $new_password, $_SESSION['user_id']);

      if ($stmt->execute()) {
          $success_message = "Your password has been updated successfully!";
      } else {
          $error_message = "There was a problem updating your password. Please try again.";
      }
    } else {
      $error_message = "Invalid old password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/settings.css"> 
  <link rel="stylesheet" href="css/logo.css">
  <link rel="stylesheet" href="css/contact-form.css">
  <link rel="shortcut icon" type="image/x-icon" href="pic/LogoForProject.png" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">

  <title>Settings</title>
</head>
<body>
  <header>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="tasks.php">Tasks</a>
      <a href="projects.php">Projects</a>
      <a href="feedback.php">Feedback</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="image-top">
  <img src="pic/set.png" alt="Image 1" />
</div>
<div class="image-middle">
  <img src="pic/set.png" alt="Image 2" />
</div>
<div class="image-bot1">
  <img src="pic/set.png" alt="Image 3" />
</div>
<div class="image-bot2">
  <img src="pic/set.png" alt="Image 4" />
</div>




  <div class="container">
  <?php 
if (isset($error_message) && !empty($error_message)) {
    echo '<div class="error-message">' . $error_message . '</div>';
}
if (isset($success_message) && !empty($success_message)) {
    echo '<div class="success-message">' . $success_message . '</div>';
}
?>
 <div class="check-password">
<h2>Check how strong is  <a href="https://howsecureismypassword.net/">Your Password </a></h2>
  </div>

  <form id="settings-form" method="post" action="settings.php">
      <label for="email">Email:</label>
      <input type="email" id="email" required>
      <label for="old_password">Old Password:</label>
      <input type="password" id="old_password" name="old_password" required>
      <label for="new_password">New Password:</label>
      <input type="password" id="new_password" name="new_password" required>
      <input type="text" id="name" required>
      <button type="submit">Update</button>
    </form>
  </div>

  <form id="contact_form" name="contact_form" method="POST">
    <input type="hidden" name="_next" value="https://fsprojecttaskmanagment.000webhostapp.com/settings.php">
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
    <img src="pic/LogoForProject.png" alt="Logo" >
  </div> 



</body>
</html>
