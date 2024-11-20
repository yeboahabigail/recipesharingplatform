<?php 
session_start();
$username = $_SESSION['fname'];
$role = $_SESSION['role'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../img/food3.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #333;
        }

        header {
            background-color: rgba(76, 175, 79, 0.856);
            color: white;
            padding: 5px 15px;
            text-align: center;
        }

        nav ul {
            list-style-type: none; /* Removes bullet points */
            margin: 0; /* Removes default margin */
            padding: 0; /* Removes default padding */
            display: flex; /* Aligns items horizontally */
        }

        nav li {
            margin-right: 20px; /* Adds space between items */
        }

        nav a {
            text-decoration: none; /* Removes underline from links */
            color: white; /* Sets link color */
            padding: 10px 15px; /* Adds padding for better click area */
            display: block; /* Makes the anchor occupy the full area */
        }

        nav a:hover {
            background-color: #ddd; /* Changes background on hover */
            color: black; /* Changes text color on hover */
        }


        main {
            padding: 10px;
        }

        .dashboard {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1 1 calc(33.333% - 40px);
            max-width: calc(33.333% - 40px);
            text-align: center;
        }

        .card h3 {
            margin: 0 0 10px;
        }

        .hidden {
            display: none;
        }

        .analytics-table-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .analytics-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .analytics-table th,
        .analytics-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .analytics-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body> 
    <header>
        <h1>Recipe Sharing Platform - Admin Dashboard</h1>
    </header>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>            
            <?php if ($role == '1') : ?>
            <li><a href="user.php">User Management</a></li>
            <?php endif; ?>
            <li><a href="recipe.php">Recipe Management</a></li>
        </ul>
    </nav>

    <main>
        <h2>Welcome, <?php echo $username; ?>!</h2>

        <!-- Dashboard Section -->
        <section id="dashboard-section" class="dashboard">
            <?php if ($role == '1') : ?>
            <div id="total-recipes" class="card">
                <h3>Total Recipes</h3>
                <p id="total-recipes-count">0</p>
            </div>
            <div id="total-users" class="card">
                <h3>Total Users</h3>
                <p id="total-users-count">0</p>
            </div>
            <div id="pending-approvals" class="card">
                <h3>Pending User Approvals</h3>
                <p id="pending-approvals-count">0</p>
            </div>
            <?php endif; ?>

            <?php if ($role == '2') : ?>
            <div id="total-recipes" class="card">
                <h3>My Recipes</h3>
                <p id="total-recipes-count">0</p>
            </div>
            <?php endif; ?>
            <div id="super-admin-controls" class="card hidden">
                <h3>Admin Tools</h3>
                <p>Manage system-wide settings and users.</p>
            </div>
        </section>

        <!-- Analytics Section -->
        <?php if ($role == '1') : ?>
        <section id="analytics-section">
            <h2>Analytics</h2>
            <div class="analytics-table-container">
                <table class="analytics-table">
                    <thead>
                        <tr>
                            <th>Recipe ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Views</th>
                            <th>Likes</th>
                        </tr>
                    </thead>
                    <tbody id="analytics-data">
                        <!-- Data will be populated dynamically -->
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', ()=>{
             // Simulate logged-in user role
        const userRole = 1; // Change to 2 for Regular Admin

// Mock data
const analyticsData = [
    { id: 1, title: 'Spaghetti Bolognese', author: 'John Doe', views: 120, likes: 45 },
    { id: 2, title: 'Chocolate Cake', author: 'Jane Smith', views: 150, likes: 60 },
    { id: 3, title: 'Grilled Chicken', author: 'Alice Brown', views: 200, likes: 80 },
];

const totalRecipes = analyticsData.length;
const totalUsers = 15; // Example count
const pendingApprovals = 5; // Example count
 

// Update dashboard
const roleText = userRole === 1 ? 'Super Admin' : 'Regular Admin';
document.getElementById('user-role').textContent = roleText;

document.getElementById('total-recipes-count').textContent = totalRecipes;
document.getElementById('total-users-count').textContent = totalUsers;
document.getElementById('pending-approvals-count').textContent = pendingApprovals;

if (userRole === 1) {
    document.getElementById('super-admin-controls').classList.remove('hidden');
}

// Populate analytics table
const analyticsTable = document.getElementById('analytics-data');
analyticsData.forEach(recipe => {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${recipe.id}</td>
        <td>${recipe.title}</td>
        <td>${recipe.author}</td>
        <td>${recipe.views}</td>
        <td>${recipe.likes}</td>
    `;
    analyticsTable.appendChild(row);
});
     });
       
    </script>
</body>
</html>
