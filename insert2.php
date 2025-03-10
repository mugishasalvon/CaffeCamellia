<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "Camellia";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $national_id = $_POST['national_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $postId=$_POST['PostId'];
    $exam_date = $_POST['exam_date'];
    $phone = $_POST['phone'];
    $marks = $_POST['marks'];
    $sql = "INSERT INTO CandidatesResult (CandidateNationalId, firstName, lastName, gender, DateOfBirth, ExamDate, PhoneNumber, Marks) 
            VALUES ('$national_id', '$first_name', '$last_name', '$gender', '$dob','$postId' '$exam_date', '$phone', '$marks')";
    if ($conn->query($sql) === TRUE) {
        echo "New candidate record inserted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>