<?php

$conn = new mysqli("localhost", "root", "", "camellia");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$username = "Mugisha";
$password = "salvo";
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $username, $hashedPassword);
    if ($stmt->execute()) {
        echo "Admin user created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing the SQL statement.";
}

$conn->close();
?>