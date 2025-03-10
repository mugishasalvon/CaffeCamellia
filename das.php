<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
    /* General styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(to right,rgb(11, 1, 104),rgb(190, 228, 19));
    }

    /* Sidebar styles */
    .sidebar {
      width: 250px;
      height: 100vh;
      background-color: #333;
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 20px;
      padding-left: 20px;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      color:rgb(255, 204, 0);
    }

    .sidebar a {
      display: block;
      color: #fff;
      text-decoration: none;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .sidebar a:hover {
      background-color:rgb(0, 248, 45);
    }

    /* Main content area */
    .main-content {
      margin-left: 250px;
      padding: 20px;
    }

    .header {
      background-color: #333;
      color: white;
      padding: 15px;
      text-align: center;
      margin-bottom: 20px;
    }

    .card {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgb(4, 25, 65);
      padding: 20px;
      margin-bottom: 20px;
    }

    .card h3 {
      margin-top: 0;
      color:rgb(16, 197, 0);
      font-size
    }

    /* Form styles */
    form input, form select, form textarea, form button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    form button {
      background-color: #333;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    form button:hover {
      background-color:rgb(33, 148, 4);
    }
    .form-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .form-container input, .form-container select, .form-container textarea {
      flex: 1 1 45%;
    }
    th{
      background-color:gren;
      color: #ffcc00;
    }

    .form-container .full-width {
      flex: 1 1 100%;
    }

  
    label {
      font-size: 14;
      margin-bottom: 5px;
      display: block;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Dashboard</h2>
    <a href="#postform">Postform</a>
    <a href="#postresult">Post Result</a>
    <a href="#candidateform">Candidate Form</a>
    <a href="#candidateresult">Candidate Result</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <h1>Welcome to the Dashboard</h1>
    </div>

    <!-- Postform Section -->
    <div id="postform" class="card">
      <h3>Postform</h3>
      <form action="addpost.php" method="POST">
        <label for="postname">Post Name:</label>
        <input type="text" id="postname" name="postname"placeholder="Description about the post" required>
        <br>
        <button type="submit">Add Post</button>
    </form>
    </div>
    <div id="postresult" class="card">
      <h3>Post Result</h3>
    </div>
    <?php
$conn = new mysqli("localhost", "root", "", "camellia");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $PostName = $_POST['PostName'];
    $sql = "INSERT INTO post (PostName) VALUES ('$PostName')";
    $conn->query($sql);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $PostId = $_POST['PostId'];
    $PostName = $_POST['PostName'];
    $sql = "UPDATE post SET PostName = '$PostName' WHERE PostId = $PostId";
    $conn->query($sql);
}
$result = $conn->query("SELECT * FROM post");
$editData = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $editResult = $conn->query("SELECT * FROM post WHERE PostId = $editId");
    if ($editResult && $editResult->num_rows > 0) {
        $editData = $editResult->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #45a049;
        }
        table {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background: rgb(23, 180, 9);
            color: white;
        }
        table tr:nth-child(even) {
            background-color: rgb(226, 219, 219);
        }
        table tr:hover {
            background-color: rgb(190, 202, 207);
        }
    </style>
</head>
<body>
    <h1>View Posts</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Post Name</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['PostId'] ?></td>
                    <td><?= $row['PostName'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
    <div id="candidateform" class="card">
      <h3>Candidate registration</h3>
      <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Candidate Info</title>
</head>
<body>

    <form action="insert2.php" method="POST">
        <div class="form-container">
            <input type="text" name="national_id" placeholder="Candidate's National ID" required>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <input type="date" name="dob" placeholder="Date of Birth" required>
            <input type="number" name="PostId" placeholder="PostId" required>
            <label for=""></label>
            <input type="date" id="exam-date" name="exam_date" placeholder="Exam Date" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="number" name="marks" placeholder="Marks" required>
        </div>
        <button type="submit">Submit Candidate</button>
    </form>
</body>
</html>
    </div>

    <div id="candidateresult" class="card">
      <h3>Candidate Result</h3>
      <p><?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "Camellia";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT CandidateNationalId, firstName, lastName, gender, DateOfBirth,PostId, ExamDate, PhoneNumber, Marks FROM CandidatesResult";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Results</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color:rgb(33, 202, 10);
        }
    </style>
</head>
<body>
    <h1>Candidate Results</h1>
    <table>
        <thead>
            <tr>
                <th>National ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>PostId</th>
                <th>Exam Date</th>
                <th>Phone Number</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody>
            <?php
      
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['CandidateNationalId'] . "</td>";
                    echo "<td>" . $row['firstName'] . "</td>";
                    echo "<td>" . $row['lastName'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['DateOfBirth'] . "</td>";
                    echo "<td>" . $row['PostId'] . "</td>";
                    echo "<td>" . $row['ExamDate'] . "</td>";
                    echo "<td>" . $row['PhoneNumber'] . "</td>";
                    echo "<td>" . $row['Marks'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?></p>
    </div>
</body>
</html>
