<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "camellia");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$editData = []; // Initialize $editData as an empty array
$result = []; // Initialize $result as an empty array

// Handle Create
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $CandidateNationalId = $_POST['CandidateNationalId'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Gender = $_POST['Gender'];
    $DateOfBirth = $_POST['DateOfBirth'];
    $PostId = $_POST['PostId'];
    $ExamDate = $_POST['ExamDate'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Marks = $_POST['Marks'];

    $sql = "INSERT INTO Candidatesresult (CandidateNationalId, FirstName, LastName, Gender, DateOfBirth, PostId, ExamDate, PhoneNumber, Marks) 
            VALUES ('$CandidateNationalId', '$FirstName', '$LastName', '$Gender', '$DateOfBirth', $PostId, '$ExamDate', '$PhoneNumber', $Marks)";
    if (!$conn->query($sql)) {
        die("Error inserting data: " . $conn->error);
    }
}

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $CandidateNationalId = $_POST['CandidateNationalId'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Gender = $_POST['Gender'];
    $DateOfBirth = $_POST['DateOfBirth'];
    $PostId = $_POST['PostId'];
    $ExamDate = $_POST['ExamDate'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Marks = $_POST['Marks'];

    $sql = "UPDATE Candidatesresult 
            SET FirstName='$FirstName', LastName='$LastName', Gender='$Gender', DateOfBirth='$DateOfBirth', ExamDate='$ExamDate', PhoneNumber='$PhoneNumber', Marks=$Marks 
            WHERE CandidateNationalId='$CandidateNationalId'";
    if (!$conn->query($sql)) {
        die("Error updating data: " . $conn->error);
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $candidatesnationalId = $_GET['delete'];
    $sql = "DELETE FROM Candidatesresult WHERE CandidateNationalId = '$candidatesnationalId'";
    if (!$conn->query($sql)) {
        die("Error deleting data: " . $conn->error);
    }
}

// Fetch all candidates
$sql = "SELECT * FROM Candidatesresult";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Error fetching data: " . $conn->error);
}

// Fetch data for editing
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $editResult = $conn->query("SELECT * FROM Candidatesresult WHERE CandidateNationalId = '$editId'");
    if ($editResult && $editResult->num_rows > 0) {
        $editData = $editResult->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        form input, form select, form button {
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
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #333;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .delete-btn, .edit-btn {
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .delete-btn:hover {
            background-color: #d32f2f;
        }
        .edit-btn {
            background-color: #2196F3;
        }
        .edit-btn:hover {
            background-color: #1976D2;
        }
        /* Logout Container */
    #logout {
        text-align: right; /* Aligns the logout link to the right */
        margin: 20px; /* Adds some margin around the logout section */
    }

    /* Logout Link Styles */
    #logout a {
        color: #ffffff; /* White text color */
        background-color: #e74c3c; /* Red background color */
        padding: 10px 15px; /* Padding around the text */
        text-decoration: none; /* Removes underline from the link */
        border-radius: 5px; /* Rounded corners */
        font-size: 16px; /* Font size */
        transition: background-color 0.3s ease; /* Smooth transition for hover effect */
    }

    /* Hover Effect */
    #logout a:hover {
        background-color: #c0392b; /* Darker red on hover */
    }
    .navbar {
            background-color: #2c3e50;
            color: white;
            padding: 15px 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Candidate Results</title>
    <style>
        /* Your existing CSS styles */
    </style>
</head>
<body>
<div class="navbar">
    MANAGER DASHBOARD FOR MANAGE CANDIDATES RESULTS
    <div id="logout">
            <a href="logout.php"> Logout</a>
        </div>
</div>

<!-- Form to Add or Update Candidate -->


<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Date of Birth</th>
            <th>Post ID</th>
            <th>Exam Date</th>
            <th>Phone Number</th>
            <th>Marks</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['CandidateNationalId'] ?></td>
                    <td><?= $row['FirstName'] ?></td>
                    <td><?= $row['LastName'] ?></td>
                    <td><?= $row['Gender'] ?></td>
                    <td><?= $row['DateOfBirth'] ?></td>
                    <td><?= $row['PostId'] ?></td>
                    <td><?= $row['ExamDate'] ?></td>
                    <td><?= $row['PhoneNumber'] ?></td>
                    <td><?= $row['Marks'] ?></td>
                    <td>
                        <a href="Candidatesresults.php?edit=<?= $row['CandidateNationalId'] ?>" class="edit-btn">Edit</a>
                        <a href="Candidatesresults.php?delete=<?= $row['CandidateNationalId'] ?>" class="delete-btn">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="10">No candidates found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
// Close connection
$conn->close();
?>
</body>
</html>