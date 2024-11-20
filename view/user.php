<?php 
include_once '../functions/user_functions.php';
session_start();
$role = $_SESSION['role'];

if ($role != '1') {
    // Redirect to login page if role is not equal to 1
    header("Location: login.php");
    exit; // Ensure no further code is executed after the redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../assets/Style4.css">
  <style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-image: url('../assets/userimage.jpg'); /* Replace with your image path */
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}

header {
    background-color: rgba(0, 0, 0, 0.7); /* Optional: add a translucent background for better readability */
    color: white;
    padding: 10px 0;
}

nav ul {
    list-style: none;
    display: flex;
    justify-content: space-around;
    padding: 0;
    margin: 0;
}

nav a {
    text-decoration: none;
    color: white;
    font-weight: bold;
}

main {
    padding: 20px;
}

.user-management {
    background-color: rgba(255, 255, 255, 0.8); /* Optional: make the section stand out */
    padding: 20px;
    border-radius: 10px;
}
button {
    padding: 10px 15px;
    margin: 5px;
    font-size: 14px;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button.read {
    background-color: #3498db; /* Blue */
}

button.update {
    background-color: #f1c40f; /* Yellow */
}

button.delete {
    background-color: #e74c3c; /* Red */
}

button.modal-button {
    padding: 10px 15px;
    margin: 5px;
    font-size: 14px;
    color: #000;
    background-color: #ecf0f1; /* Light Gray */
    border: 1px solid #bdc3c7;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    opacity: 0.9;
}

.modal-content span {
    font-size: 20px;
    font-weight: bold;
    float: right;
    color: #333;
}


</style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="login.php">User Management</a></li>
                <li><a href="recipe.php">Recipe Management</a></li>
                <li><a href="register.php">Recipe Management</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="user-management">
            <h2>User Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php displayUsers(); // Call the function to display users ?>
                </tbody>
                </table>

<form id="registerForm" onsubmit="return createUser();">
    <h3>Create User</h3>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <div id="errorMessage"></div>
    <button type="submit">Create</button>
</form>
</section>

<!-- Delete Confirmation Modal -->
<div id="confirmDeleteModal" class="modal">
<div class="modal-content">
    <p id="deleteMessage"></p>
    <button id="confirmYes" class="modal-button">Yes</button>
    <button id="confirmNo" class="modal-button">No</button>
</div>
</div>

<!-- Modal for viewing more user details -->
<div id="userModal" class="modal">
<div class="modal-content">
    <span onclick="closeUserModal()" style="cursor: pointer;">&times;</span>
    <div id="userDetails" class="user-details"></div>
</div>
</div>
</main>

<script>
let users = [
{ id: 1, name: "Abigail Yeboah", email: "abigailyeboah@gmail.com" },
{ id: 2, name: "John Amuzu", email: "johnamuzu@gmail.com" },
{ id: 3, name: "Akwesi Doe", email: "akwesidoe@yahoo.com" }
];
let nextId = 4;

// Load users into the table
function loadUsers() {
const userTableBody = document.querySelector('#userTable tbody');
userTableBody.innerHTML = ''; // Clear existing rows

users.forEach(user => {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${user.id}</td>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td>
            <button class="read" onclick="viewMore(${user.id})">View More</button>
            <button class="update" onclick="updateUser(${user.id})">Update</button>
            <button class="delete" onclick="confirmDelete(${user.id})">Delete</button>
        </td>
    `;
    userTableBody.appendChild(row);
});
}

// Create User function
function createUser() {
const name = document.getElementById('name').value;
const email = document.getElementById('email').value;
const password = document.getElementById('password').value;

if (validateEmail(email)) {
    const newUser = {
        id: nextId++,
        name: name,
        email: email,
        password: password
    };
    users.push(newUser);
    loadUsers();
    document.getElementById('registerForm').reset(); // Reset the form
    return false; // Prevent form submission
} else {
    alert('Invalid email format');
    return false; // Prevent form submission
}
}
// Update User Function
function updateUser(userId) {
    const user = users.find(user => user.id === userId);
    if (!user) return;

    const newName = prompt("Update Name:", user.name);
    const newEmail = prompt("Update Email:", user.email);

    if (newName && validateEmail(newEmail)) {
        user.name = newName;
        user.email = newEmail;
        loadUsers();
        alert('User updated successfully.');
    } else {
        alert('Invalid input. Please try again.');
    }
}


// Validate Email Format
function validateEmail(email) {
const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
return emailPattern.test(email);
}

// Confirm Delete function (showing custom modal)
function confirmDelete(userId) {
const modal = document.getElementById("confirmDeleteModal");
modal.style.display = "block";
document.getElementById("deleteMessage").textContent = "Are you sure you want to delete user " + userId + "?";

document.getElementById("confirmYes").onclick = function() {
    deleteUser(userId);
    closeModal(); // Close the modal after confirming
};

document.getElementById("confirmNo").onclick = function() {
    closeModal(); // Simply close the modal if they click No
};
}

// Delete User Function
function deleteUser(userId) {
users = users.filter(user => user.id !== userId);
loadUsers(); // Refresh the user table
alert('User ' + userId + ' deleted.');
}

// Close Confirmation Modal
function closeModal() {
document.getElementById("confirmDeleteModal").style.display = "none";
}

// View More Function (fetches user details)
function viewMore(userId) {
const user = users.find(user => user.id === userId);
const userDetails = `
    <p>Name: ${user.name}</p>
    <p>Email: ${user.email}</p>
    <p>Role: ${user.id === 1 ? 'Admin' : 'User'}</p>
`;

document.getElementById("userDetails").innerHTML = userDetails;
document.getElementById("userModal").style.display = "block"; // Show the modal
}

// Close User Details Modal
function closeUserModal() {
document.getElementById('userModal').style.display = 'none';
}

// Initialize the table on page load
window.onload = loadUsers;
</script>
</body>
</html>
