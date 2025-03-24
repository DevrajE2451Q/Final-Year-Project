<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CW";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST["firstName"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]); // Store password as plain text (not recommended)

    // Use a prepared statement to prevent SQL injection
    $sql = "INSERT INTO registrations (firstName, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $firstName, $email, $password);

    if ($stmt->execute()) {
        // JavaScript alert for 2 seconds, then redirect
        echo "<script>
                alert('Registration successful! Welcome, $firstName!');
                setTimeout(function() {
                    window.location.href = 'index.html';
                }, 500);
              </script>";
        exit();
    } else {
        echo "<script>alert('Error: Could not register. Please try again.'); window.location.href='Registration.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
