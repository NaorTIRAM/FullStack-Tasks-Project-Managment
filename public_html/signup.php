<?php
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = password_hash(trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)), PASSWORD_DEFAULT);

    $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $username, $email, $password);

    if ($stmt->execute()) {
        header('Location: index.php');  // redirect to login page
        exit();
    } else {
        $error_message = "There was a problem creating your account. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/logo.css">
  <link rel="stylesheet" href="css/contact-form.css">
  <link rel="shortcut icon" type="image/x-icon" href="pic/LogoForProject.png" />

  <title>Sign Up</title>
</head>
<body>

  <div class="container">
    <h1>Sign Up</h1>
    <form id="signup-form" method="post" action="signup.php">
  <label for="username">Name:</label>
  <input type="text" id="username" name="username" required>
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required>
  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required>
  <button type="submit">Sign Up</button>
</form>
    <p>Already have an account? <a href="index.php">Login</a></p>
  </div>

</div>
<form id="contact_form" name="contact_form"  method="POST">
    <input type="hidden" name="_next" value="http://localhost/FullStackProject/feedback.php">
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
</div>


  <div class="image-bottom">
    <img src="pic/LogoForProject.png" alt="description of your image">
  </div> 


  <script src="js/script.js"></script>
</body>
</html>
