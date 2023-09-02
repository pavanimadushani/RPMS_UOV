<?php
// Include the database connection file
include 'database.php';

// Retrieve the research project ID from the URL parameter
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  // If no ID was provided, redirect to the homepage
  header('Location: studentDashboard.php');
  exit;
}

// Retrieve the research project details from the database
$sql = "SELECT rp_NameWithInitials, rp_regNo, rp_title, rp_year, rp_description, rp_sources, rp_projectLink, rp_references, rp_image FROM researchProjects WHERE rp_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// If no research project was found with the provided ID, redirect to the homepage
if (!$row) {
  header('Location: studentDashboard.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="resPro.css">
  <title>Document</title>
</head>
<body>
    <!-- Display the research project details -->
    <h1><?php echo $row['rp_title']; ?></h1>

    <div><strong>Name With Initials:</strong></div>
    <div> <?php echo $row['rp_NameWithInitials']; ?></div>
<br>
    <div><strong>Registration Number:</strong> </div>
    <div> <?php echo $row['rp_regNo']; ?></div>
<br>
    <div><strong>Year:</strong> </div>
    <div> <?php echo $row['rp_year']; ?></div>
<br>
    <div><strong>Description:</strong> </div>
    <div> <?php echo $row['rp_description']; ?></div>
<br>
    <div><strong>Sources:</strong> </div>
    <div> <?php echo $row['rp_sources']; ?></div>
<br>
    <div><strong>Project Link:</strong> </div>
    <div><a href="<?php echo $row['rp_projectLink']; ?>"> <?php echo $row['rp_projectLink']; ?></a></div>
 <br>   
    <div><strong>References:</strong> </div>
    <div> <?php echo $row['rp_references']; ?></div>
<br>
    <a href="studentDashboard.php" class="btdb">Back to List</a>
</body>
</html>


