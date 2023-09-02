<?php
// Start a session to store user data
session_start();

// Include the database.php file
include 'database.php';

// Check the database connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Retrieve the form data
  $name = $_POST['name'];
  $regNo = $_POST['regNo'];
  $email = $_POST['email'];
  $contactNo = $_POST['contactNo'];
  $password = $_POST['password'];
  

    // Validate the form data
    if (empty($name) || empty($regNo) || empty($email) || empty($contactNo) || empty($password)) {
      $error = "Please fill in all fields.";
    } else {

    // Sanitize the password variable
    $password = mysqli_real_escape_string($conn, $password);

    // Prepare the SQL statement
    $sql = "INSERT INTO studentDetails (st_NameWithInitials, st_regNo, st_email, st_contactNo, st_password) VALUES ('$name', '$regNo', '$email', '$contactNo', '$password')";
    
    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
      // Store the user data in a session variable
      $_SESSION['user'] = [
        'name' => $name,
        'regNo' => $regNo,
        'email' => $email,
        'contactNo' => $contactNo
      ];

      // Redirect the user to the signin page
      header('Location:index.php');
      exit();
    } else {
      $error = "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="signup.css">
  <title>Signup</title>
</head>
<body>
  
  <?php if (isset($error)) { echo "<p>$error</p>"; } ?>

  <div class="idk">
      <div class="leftPanel">
        <img src="RESOURCES\logo.png" alt="">
      </div>

      <div class="rightPanel">
          <div class="allC cbd">
            <h1>Signup</h1>
          <form method="post">

            <div class="allC allC1">
              <div><label for="name">Name with Initials</label></div>
              <div><input type="text" name="name" id="name" required></div>
            </div>

            <div class="allC allC2">
              <div><label for="regNo">Registration Number:</label></div>
              <div><input type="text" name="regNo" id="regNo" required></div>
            </div>

            <div class="allC allC2">
              <div><label for="email">Email</label></div>
              <div><input type="email" name="email" id="email" required></div>
            </div>

            <div class="allC allC2">
              <div><label for="contactNo">Contact Number</label></div>
              <div><input type="text" name="contactNo" id="contactNo" required></div>
            </div>

            <div class="allC allC2">
              <div><label for="password">Password</label></div>
              <div><input type="password" name="password" id="password" required></div>
            </div>

            <div class="allC allC3"><input type="submit" name="submit" value="Sign Up" class="btn">
            <div class="allC allC4"><span>Already Have an account <br><a href="index.php">SIGNIN</a></span></div>
          </form>
          </div>
      </div>
    </div>



</body>
</html>
