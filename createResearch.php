<?php
// Start a session to retrieve the student ID and name
session_start();
if (!isset($_SESSION['st_ID']) || empty($_SESSION['st_ID'])) {
  // Redirect to the sign in page
  header("Location: index.php");
  exit;
}

// Include the database connection file
include 'database.php';

// Retrieve the student's name and registration number from the session
$st_NameWithInitials = $_SESSION['name'];
$st_regNo = $_SESSION['regNo'];

// Define variables to hold form input values
$rp_title = '';
$rp_year = '';
$rp_description = '';
$rp_sources = '';
$rp_projectLink = '';
$rp_references = '';
$rp_image = '';

// Define an error message variable
$error_msg = '';

// If the form was submitted, validate the inputs and insert the research project record into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validate the input values
  $rp_title = $_POST['rp_title'];
  $rp_year = $_POST['rp_year'];
  $rp_description = $_POST['rp_description'];
  $rp_sources = $_POST['rp_sources'];
  $rp_projectLink = $_POST['rp_projectLink'];
  $rp_references = $_POST['rp_references'];

  // Validate the file input
  if (!empty($_FILES['rp_image']['tmp_name'])) {
    $rp_image = file_get_contents($_FILES['rp_image']['tmp_name']);
    $rp_image_type = $_FILES['rp_image']['type'];
    if (!preg_match('/^image\/(jpeg|png|gif)$/', $rp_image_type)) {
      $error_msg = 'Invalid file type for project image. Only JPEG, PNG, and GIF images are allowed.';
    }
  }

  // If there are no errors, insert the record into the database
  if (empty($error_msg)) {
    $sql = "INSERT INTO researchProjects (rp_NameWithInitials, rp_regNo, rp_title, rp_year, rp_description, rp_sources, rp_projectLink, rp_references, rp_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissssb", $st_NameWithInitials, $st_regNo, $rp_title, $rp_year, $rp_description, $rp_sources, $rp_projectLink, $rp_references, $rp_image);
    if ($stmt->execute()) {
      // Redirect to the student dashboard
      header("Location: studentDashboard.php");
      exit;
    } else {
      $error_msg = 'Error inserting research project record into the database.';
    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="createResearch.css">
  <title>Create New Research Project</title>
</head>
<body>
  <h1>Create New Research Project</h1>
  <?php if (!empty($error_msg)): ?>
    <p style="color: red;"><?php echo $error_msg; ?></p>
  <?php endif; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="formIn">
      <div>
        <div><label for="rp_title">Title:</label></div>
        <div><input type="text" id="rp_title" name="rp_title" required></div>
      </div>
  
      <div>
        <div><label for="rp_year">Year:</label></div>
        <div><input type="number" id="rp_year" name="rp_year" min="1900" max="<?php echo date('Y'); ?>" required></div>
      </div>

      <div>
        <div><label for="rp_description">Description:</label></div>
        <div><textarea id="rp_description" name="rp_description" rows="5" cols="40" required></textarea></div>
      </div>

      <div>
        <div><label for="rp_sources">Sources:</label></div>
        <div><textarea id="rp_sources" name="rp_sources" rows="5" cols="40" required></textarea></div>
      </div>

      <div>
        <div><label for="rp_projectLink">Project Link:</label></div>
        <div><input type="url" id="rp_projectLink" name="rp_projectLink"></div>
      </div>

      <div>
        <div><label for="rp_references">References:</label></div>
        <div><textarea id="rp_references" name="rp_references" rows="5" cols="40"></textarea></div>
      </div>

    <!--<label for="rp_image">Project Image:</label><br>
    <input type="file" id="rp_image" name="rp_image"><br><br>-->
    
    
    <input class="sBtn" type="submit" value="Create Project">
    </div>
    </form>
</body>
</html>