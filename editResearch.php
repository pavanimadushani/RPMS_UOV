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

// Retrieve all research project records from the database for the current user
$sql = "SELECT * FROM researchProjects WHERE rp_NameWithInitials = ? AND rp_regNo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $st_NameWithInitials, $st_regNo);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="editResearch.css">
  <title>Edit Research Projects</title>
</head>
<body>

  <h1>Edit Research Projects</h1>

  <?php
  // If there are no research project records for the current user, display a message
  if ($result->num_rows === 0) {
    echo '<p>No research projects found for the current user.</p>';
  } else {
    // Display a table of all the research project records for the current user
    echo '<table>';
    echo '<tr><th>Title</th><th>Year</th><th>Project Link</th><th>Action</th></tr>';
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo '<td>' . $row['rp_title'] . '</td>';
      echo '<td>' . $row['rp_year'] . '</td>';
      //echo '<td>' . $row['rp_description'] . '</td>';
      //echo '<td>' . $row['rp_sources'] . '</td>';
      echo '<td>' . $row['rp_projectLink'] . '</td>';
      //echo '<td>' . $row['rp_references'] . '</td>';
      /*if ($row['rp_image']) {
        echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['rp_image']) . '"/></td>';
      } else {
        echo '<td></td>';
      }*/
      echo '<td><a class="lnk" href="editResearchForm.php?rp_ID=' . $row['rp_ID'] . '">Edit</a></td>';
      echo '</tr>';
    }
    echo '</table>';
  }
  ?>

</body>
</html>
