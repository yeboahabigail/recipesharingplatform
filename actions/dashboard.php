<?php
session_start();
require '../db/conf.php'; // Include DB connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user role from session
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role']; // 1 = Super Admin, 2 = Regular Admin

// Initialize response data
$response = [
    'analytics' => [],
    'users' => [],
    'recipes' => [],
];

// Fetch analytics based on role
if ($user_role == 1) { // Super Admin
    // Total Users
    $result = $conn->query("SELECT COUNT(*) AS total_users FROM users");
    $response['analytics']['total_users'] = $result->fetch_assoc()['total_users'];

    // Total Recipes
    $result = $conn->query("SELECT COUNT(*) AS total_recipes FROM recipes");
    $response['analytics']['total_recipes'] = $result->fetch_assoc()['total_recipes'];

    // Pending Approvals
    $result = $conn->query("SELECT COUNT(*) AS pending_approvals FROM users WHERE status = 'pending'");
    $response['analytics']['pending_approvals'] = $result->fetch_assoc()['pending_approvals'];

    // Fetch all users
    $result = $conn->query("SELECT fname,lname, email, role, registration_date FROM users");
    while ($row = $result->fetch_assoc()) {
        $response['users'][] = $row;
    }

    // Fetch all recipes
    $result = $conn->query("SELECT id, title, author, created_at FROM recipes ORDER BY created_at DESC LIMIT 10");
    while ($row = $result->fetch_assoc()) {
        $response['recipes'][] = $row;
    }
} elseif ($user_role == 2) { // Regular Admin
    // Total Recipes by this admin
    $result = $conn->query("SELECT COUNT(*) AS total_recipes FROM recipes WHERE created_by = $user_id");
    $response['analytics']['total_recipes'] = $result->fetch_assoc()['total_recipes'];

    // Fetch recent recipes by this admin
    $result = $conn->query("SELECT id, title, status, created_at FROM recipes WHERE created_by = $user_id ORDER BY created_at DESC");
    while ($row = $result->fetch_assoc()) {
        $response['recipes'][] = $row;
    }
}

// Return data as JSON for front-end
header('Content-Type: application/json');
echo json_encode($response);
?>
