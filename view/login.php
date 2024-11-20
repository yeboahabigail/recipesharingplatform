<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Link to external CSS -->
  <link rel="stylesheet" href="../assets/Style4.css">
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="user.php">User Management</a></li>
        <li><a href="recipe.php">Recipe Management</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <!-- Section with background image -->
  <section id="home">
    <!-- Content for background can be added here if needed -->
  </section>

  <!-- Login form container -->
  <div class="login-body">
    <div class="login">
      <!-- Login form -->
      <form id="loginForm" action="../actions/login_user.php" method="POST">
        <label for="chk" aria-hidden="true">Login</label>

        <!-- Error message div -->
        <?php if (isset($_GET['error'])): ?>
          <div class="error" id="errorMsg"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <!-- Table to organize the form fields for Login -->
        <table>
          <tr>
            <td>
              <input type="email" id="email" name="email" placeholder="Email" required>
            </td>
          </tr>
          <tr>
            <td>
              <input type="password" id="password" name="password" placeholder="Password" required>
            </td>
          </tr>
        </table>

        <!-- Submit button -->
        <button type="submit">Login</button>

        <!-- Optional link for Register or Forgot Password -->
        <p><a href="register.php" class="toggle-link">Register</a></p>
      </form>
    </div>
  </div>

  <!-- Link to external JavaScript -->
  <script src="Script.js"></script>
</body>
</html>
