<?php
// Start session for login tracking
session_start();

// Include database connection
require_once '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize inputs
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    // Validation checks
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Both fields are required.";
        header('Location: ../view/login.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header('Location: ../view/login.php');
        exit();
    }

    // Fetch user data
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['_user_id'];
            $_SESSION['fname'] = $user['fname'];
            $_SESSION['lname'] = $user['lname'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
    
            header('Location: ../view/dashboard.php');
            exit();
        } else {
            $_SESSION['error'] = "Invalid credentials.";
            $stmt->close();
            $conn->close();
            header('Location: ../view/login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid credentials.";
        $stmt->close();
        $conn->close();
        header('Location: ../view/login.php');
        exit();
    }
} else {
    header('Location: ../view/login.php');
    exit();
}
?>
