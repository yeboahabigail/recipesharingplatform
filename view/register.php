<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="../assets/Style4.css">
    <style>
        body {
            background-image: url('../img/food2.jpeg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            font-family: Arial, sans-serif;
        }

       
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.html">Dashboard</a></li>
                <li><a href="user.html">User Management</a></li>
                <li><a href="recipe.html">Recipe Management</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </nav>
    </header>
    <header>
        <h1>Registration Form</h1>
    </header>

    <main>
        <form action = "../actions/register_user.php" method="POST">
            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name= "fname" required>
            <span class="error" id="first-name-error"></span>

            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name= "lname" required>
            <span class="error" id="last-name-error"></span>

            <label for="email">Email:</label>
            <input type="email" id="email" name= "email" required>
            <span class="error" id="email-error"></span>

            <label for="password">Password:</label>
            <input type="password" id="password" name= "password" required>
            <span class="error" id="password-error"></span>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name= "cpass" required>
            <span class="error" id="confirm-password-error"></span>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </main>
    <!-- <script src="../assets/Script.js" defer></script> -->
</body>
</html>
