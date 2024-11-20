<?php
// actions/recipes_action.php

// Include database configuration
require_once '../db/updated_recipe_sharing.php';

// Start session to track user
session_start();

// Check if a user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

// Process user actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'add_recipe':
            addRecipe();
            break;

        case 'update_recipe':
            updateRecipe();
            break;

        case 'delete_recipe':
            deleteRecipe();
            break;

        default:
            echo "Invalid action.";
    }
}

// Add a new recipe
function addRecipe() {
    global $conn; // Use global MySQLi connection
    // Get form inputs
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $ingredients = $_POST['ingredients'] ?? '';
    $steps = $_POST['steps'] ?? '';
    $user_id = $_SESSION['user_id']; // Get logged-in user's ID

    // Validate input
    if (empty($title) || empty($description) || empty($ingredients) || empty($steps)) {
        echo "All fields are required.";
        return;
    }

    // Prepare and execute query
    $query = "INSERT INTO recipes (user_id, title, description, ingredients, steps, created_at) 
              VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $user_id, $title, $description, $ingredients, $steps);

    if ($stmt->execute()) {
        echo "Recipe added successfully!";
    } else {
        echo "Error adding recipe: " . $conn->error;
    }

    $stmt->close();
}

// Update an existing recipe
function updateRecipe() {
    global $conn; // Use global MySQLi connection
    $recipe_id = $_POST['recipe_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $ingredients = $_POST['ingredients'] ?? '';
    $steps = $_POST['steps'] ?? '';

    // Validate input
    if (empty($recipe_id) || empty($title) || empty($description) || empty($ingredients) || empty($steps)) {
        echo "All fields are required.";
        return;
    }

    // Prepare and execute query
    $query = "UPDATE recipes SET title = ?, description = ?, ingredients = ?, steps = ?, updated_at = NOW() 
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $title, $description, $ingredients, $steps, $recipe_id);

    if ($stmt->execute()) {
        echo "Recipe updated successfully!";
    } else {
        echo "Error updating recipe: " . $conn->error;
    }

    $stmt->close();
}

// Delete a recipe
function deleteRecipe() {
    global $conn; // Use global MySQLi connection
    $recipe_id = $_POST['recipe_id'] ?? '';

    if (empty($recipe_id)) {
        echo "Recipe ID is required.";
        return;
    }

    // Prepare and execute query
    $query = "DELETE FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $recipe_id);

    if ($stmt->execute()) {
        echo "Recipe deleted successfully!";
    } else {
        echo "Error deleting recipe: " . $conn->error;
    }

    $stmt->close();
}
?>
