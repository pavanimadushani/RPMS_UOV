<?php
// Start a session to store the student ID
session_start();

// Include the database connection file
include 'database.php';

// Check if the user is already logged in
if (isset($_SESSION['st_ID']) && !empty($_SESSION['st_ID'])) {
  // Redirect to the dashboard
  header("Location: studentDashboard.php");
  exit;
}

// Check if the user submitted the form
if (isset($_POST['submit'])) {
  // Get the submitted registration number and password
  $regNo = $_POST['regNo'];
  $password = $_POST['password'];

  // Query the database for a student with the given registration number and password
  $sql = "SELECT * FROM studentDetails WHERE st_regNo = '$regNo' AND st_password = '$password'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) == 1) {
    // Authentication succeeded - set the session variable and redirect to the dashboard
    $row = mysqli_fetch_assoc($result);
    $_SESSION['st_ID'] = $row['st_ID'];
    header("Location: studentDashboard.php");
    exit;
  } else {
    // Authentication failed - display an error message
    $error = "Invalid registration number or password";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="login.css">
  <title>Student Sign In</title>
</head>
<body>
  <?php if (isset($error)) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php } ?>

    <div class="idk">
      <div class="leftPanel">
        <img src="RESOURCES\logo.png" alt="">
      </div>

      <div class="rightPanel">
          <div class="allC cbd">
            <h1>Student Sign In</h1> 
          <form method="post">
            <div class="allC allC1">
              <div><label>Registration Number</label></div>
              <div><input type="text" name="regNo"></div>
            </div>
            <div class="allC allC2">
              <div><label>Password</label></div>
              <div><input type="password" name="password"></div>
            </div>
            <div class="allC allC3"><input type="submit" name="submit" value="Sign In" class="btn">
            <div class="allC allC4"><span>Don't Have an account <br><a href="signup.php">SIGNUP</a></span></div>
          </form>
          </div>
      </div>
    </div>
    

</body>
</html>
