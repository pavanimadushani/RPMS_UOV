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

// Define an error message variable
$error_msg = '';

// If the research project ID was not provided, redirect to the student dashboard
if (!isset($_GET['rp_ID']) || empty($_GET['rp_ID'])) {
  header("Location: studentDashboard.php");
  exit;
}

// Retrieve the research project record from the database
$rp_ID = $_GET['rp_ID'];
$sql = "SELECT * FROM researchProjects WHERE rp_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $rp_ID);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
  // If the research project record was not found, redirect to the student dashboard
  header("Location: studentDashboard.php");
  exit;
}
$row = $result->fetch_assoc();

// Check if the research project record belongs to the current user
if ($row['rp_NameWithInitials'] !== $st_NameWithInitials || $row['rp_regNo'] !== $st_regNo) {
  // If the research project record does not belong to the current user, redirect to the student dashboard
  header("Location: studentDashboard.php");
  exit;
}

// Set the form input values to the current values of the research project record
$rp_title = $row['rp_title'];
$rp_year = $row['rp_year'];
$rp_description = $row['rp_description'];
$rp_sources = $row['rp_sources'];
$rp_projectLink = $row['rp_projectLink'];
$rp_references = $row['rp_references'];
$rp_image = $row['rp_image'];

// If the form was submitted, validate the inputs and update the research project record in the database
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

  // If there are no errors, update the record in the database
  if (empty($error_msg)) {
    // Prepare and execute the update statement
    $sql = "UPDATE researchProjects SET rp_title = ?, rp_year = ?, rp_description = ?, rp_sources = ?, rp_projectLink = ?, rp_references = ?, rp_image = ? WHERE rp_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssssi", $rp_title, $rp_year, $rp_description, $rp_sources, $rp_projectLink, $rp_references, $rp_image, $rp_ID);
    $stmt->execute();
    // Redirect to the student dashboard
header("Location: studentDashboard.php");
exit;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Research Project</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <link rel="stylesheet" href="erf.css">
    <h1>Edit Research Project</h1>
  </header>
  <main>
    <form action="" method="POST" enctype="multipart/form-data">
  <div class="formIn">
  <div>
  <div><label for="rp_title">Title:</label></div>
  <div><input type="text" name="rp_title" id="rp_title" value="<?php echo htmlspecialchars($rp_title); ?>" required></div>
  </div>

  <div>
  <div><label for="rp_year">Year:</label></div>
  <div><input type="number" name="rp_year" id="rp_year" min="1900" max="2099" value="<?php echo htmlspecialchars($rp_year); ?>" required></div>
  </div>

  <div>
  <div><label for="rp_description">Description:</label></div>
  <div><textarea name="rp_description" id="rp_description" required><?php echo htmlspecialchars($rp_description); ?></textarea></div>
  </div>

  <div>
  <div><label for="rp_sources">Sources:</label></div>
  <div><textarea name="rp_sources" id="rp_sources" required><?php echo htmlspecialchars($rp_sources); ?></textarea></div>
  </div>

  <div>
  <div><label for="rp_projectLink">Project Link:</label></div>
  <div><input type="url" name="rp_projectLink" id="rp_projectLink" value="<?php echo htmlspecialchars($rp_projectLink); ?>" required></div>
  </div>

  <div>
  <div><label for="rp_references">References:</label></div>
  <div><textarea name="rp_references" id="rp_references" required><?php echo htmlspecialchars($rp_references); ?></textarea></div>
  </div>



  <div class="error"><?php echo $error_msg; ?></div>

  <input type="submit" value="Save Changes" class="btnSC">

  <div>
</form>
</main>
  <footer>
    <a class="btdb" href="studentDashboard.php">Back to Dashboard</a>
  </footer>
</body>
</html>

