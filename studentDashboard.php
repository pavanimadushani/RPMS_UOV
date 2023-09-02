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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$st_ID = $_SESSION['st_ID'];

$sql = "SELECT st_NameWithInitials, st_regNo FROM studentDetails WHERE st_ID=$st_ID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Set session variables with retrieved data
  $row = $result->fetch_assoc();
  $_SESSION['name'] = $row["st_NameWithInitials"];
  $_SESSION['regNo'] = $row["st_regNo"];
} else {
  // Redirect to the sign in page
  header("Location: index.php");
  exit;
}

$conn->close();

$st_NameWithInitials = $_SESSION['name'];
$st_regNo = $_SESSION['regNo'];

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="sDashboard.css">
  <title>Student Dashboard</title>
</head>
<body>

<div class="mainArea">
<div class="leftArea">
  <div>
    <h1>STUDENT DASHBOARD</h1>
      <h2>Welcome, <?php echo $st_NameWithInitials; ?>!</h2>
      <h3><?php echo $st_regNo; ?></h3>

      <h4>What would you like to do?</h4>

      <a href="createResearch.php">Create New Research Project</a><br>
      
      <a href="editResearch.php">Edit Existing Research Project</a>
  </div>
  <div>
    <form method="post" action="logout.php">
      <input type="submit" name="logout" value="Logout" class="btn">
    </form>
  </div>
</div>
 


<?php
// Include the database connection file
include 'database.php';

// Define the number of records per page
$records_per_page = 10;

// Retrieve the current page number from the URL query string
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// If the search form was submitted, construct the search query
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $search_title = '%' . $_POST['search_title'] . '%';
  $sql = "SELECT rp_id, rp_title, rp_regNo, rp_year FROM researchProjects WHERE rp_title LIKE ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $search_title);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  // If no search was performed, retrieve all records from the database with pagination
  $start = ($page - 1) * $records_per_page;
  $sql = "SELECT rp_id, rp_title, rp_regNo, rp_year FROM researchProjects LIMIT ?, ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $start, $records_per_page);
  $stmt->execute();
  $result = $stmt->get_result();
}
?>

<!-- Display the search form -->

<div class="rightArea">
  <div class="searchArea">
  <form method="POST">
      <label for="search_title">Search by title:</label>
      <input type="text" id="search_title" name="search_title">
      <button class="btnS" type="submit">Search</button>
      <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <button class="btnR" type="button" onclick="window.location.href='?page=<?php echo $page; ?>'">Reset Search</button>
      <?php endif; ?>
    </form>
  </div>


    <table>
      <tr>
        <th>Title</th>
        <th>Registration Number</th>
        <th>Year</th>
        <th>Details</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><a href="researchProject.php?id=<?php echo $row['rp_id']; ?>"><?php echo $row['rp_title']; ?></a></td>
          <td><?php echo $row['rp_regNo']; ?></td>
          <td><?php echo $row['rp_year']; ?></td>
          <td><a class="a2" href="researchProject.php?id=<?php echo $row['rp_id']; ?>">View Details</a></td>
        </tr>
      <?php endwhile; ?>
    </table>

  </div>
      </div>

</body>
</html>

<!-- Display the pagination links -->
<?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
  <?php
  $sql = "SELECT COUNT(*) FROM researchProjects";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $total_records = $row['COUNT(*)'];
  $total_pages = ceil($total_records / $records_per_page);
  ?>

  <?php if ($page > 1): ?>
    <a href="?page=<?php echo $page - 1; ?>">Previous</a>
  <?php endif; ?>

  <?php if ($page < $total_pages): ?>
    <a href="?page=<?php echo $page + 1; ?>">Next</a>
  <?php endif; ?>
<?php endif; ?>

