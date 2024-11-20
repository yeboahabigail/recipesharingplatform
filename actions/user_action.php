<?php
include('../db/config.php'); // Include the database connection file

// Check if an 'id' parameter is passed in the URL (GET method)
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    // Sanitize the input to prevent SQL Injection
    $userId = (int)$_GET['user_id'];

    // Create the SQL DELETE query
    $sql = "DELETE FROM users WHERE user_id = ?"; // Assuming the table is 'users'

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the user ID parameter to the statement
        $stmt->bind_param('i', $userId); // 'i' means integer

        // Execute the DELETE query
        if ($stmt->execute()) {
            // Redirect to the user management page after successful deletion
            header("Location: ../view/user.php?message=User deleted successfully.");
            exit();
        } else {
            // In case of failure, show an error message
            echo "Error deleting user: " . $conn->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }
} else {
    echo "Invalid user ID or user ID not set.";
}

// Close the database connection
$conn->close();
?>
