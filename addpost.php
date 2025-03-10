<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "Camellia";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to the database!";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postname = $_POST['postname'];

    $sql = "INSERT INTO post (postname) VALUES ('$postname')";
    if ($conn->query($sql) === TRUE) {
        echo "Post added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>