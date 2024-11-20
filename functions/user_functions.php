<?php
include('../db/config.php'); // Include the database connection

function displayUsers() {
    global $conn; // Access the $conn MySQLi connection from config.php

    // Write the query to select all users from the 'users' table
    $sql = "SELECT user_id, fname, email FROM users"; // Assuming the table is called 'users'
    $result = $conn->query($sql); // Execute the query

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Loop through the results and display each user
        while ($user = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$user['user_id']}</td>
                    <td>{$user['fname']}</td>
                    <td>{$user['email']}</td>
                    <td><a href='edit_user.php?id={$user['user_id']}'>Edit</a> | <a href='../actions/user_action.php?user_id={$user['user_id']}'>Delete</a></td>
                </tr>";
        }
    } else {
        // If no users are found, display a message
        echo "<tr><td colspan='4'>No users found.</td></tr>";
    }
}
?>
