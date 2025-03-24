<?php
session_start();

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
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]); // Plain text password

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT * FROM registrations WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and password matches
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['firstName'] = $row['firstName'];

        // JavaScript alert for 2 seconds, then redirect
        echo "<script>
                alert('Welcome, " . $row['firstName'] . "!');
                setTimeout(function() {
                    window.location.href = 'index.html';
                }, 500);
              </script>";
        exit();
    } else {
        echo "<script>alert('Invalid email or password. Please try again.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
