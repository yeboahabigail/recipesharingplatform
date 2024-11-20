<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Management</title>
    <style>
        body {
            background-image: url('../img/Pizza.jpeg'); /* Replace with your image URL */
            background-size: cover; /* Ensures the image covers the entire page */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-attachment: fixed; /* Keeps the image fixed during scrolling */
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #333;
        }

        header nav ul li {
            margin: 0;
            padding: 10px 20px;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
        }

        header nav ul li a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            margin: 20px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: purple;
            font-weight: bold;
        }

        form.create-recipe {
            margin-top: 20px;
        }

        form.create-recipe label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        form.create-recipe input, form.create-recipe textarea, form.create-recipe select, form.create-recipe button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form.create-recipe button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        form.create-recipe button:hover {
            background-color: #218838;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="user.php">User Management</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="recipe-management">
            <h2>Recipe Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="recipe-list"></tbody>
            </table>

            <form class="create-recipe" id="create-recipe-form">
                <h3>Add Recipe</h3>
                <label for="title">Recipe Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="cooking-time">Cooking Time:</label>
                <input type="number" id="cooking-time" name="cooking-time" required min="1">

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>

                <label for="origin">Origin of Ingredients:</label>
                <input type="text" id="origin" name="origin" required>

                <label for="ingredients">Ingredients:</label>
                <textarea id="ingredients" name="ingredients" required placeholder="List of ingredients"></textarea>

                <label for="nutritional-value">Nutritional Value:</label>
                <textarea id="nutritional-value" name="nutritional-value" required></textarea>

                <label for="allergen-info">Allergen Information:</label>
                <input type="text" id="allergen-info" name="allergen-info" placeholder="List allergens">

                <label for="shelf-life">Shelf Life:</label>
                <input type="text" id="shelf-life" name="shelf-life" required>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="unit">Unit:</label>
                <select id="unit" name="unit" required>
                    <option value="cups">Cups</option>
                    <option value="tablespoons">Tablespoons</option>
                    <option value="grams">Grams</option>
                    <option value="liters">Liters</option>
                    <option value="pieces">Pieces</option>
                </select>

                <label for="recipe-image">Recipe Image:</label>
                <input type="file" id="recipe-image" name="recipe-image" accept="image/*" required>

                <label for="prep-time">Preparation Time (in minutes):</label>
                <input type="number" id="prep-time" name="prep-time" required>

                <label for="instructions">Instructions:</label>
                <textarea id="instructions" name="instructions" required></textarea>

                <button type="submit">Add Recipe</button>
            </form>
        </section>
    </main>

    <div id="recipe-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 id="modal-title"></h3>
            <p id="modal-details"></p>
        </div>
    </div>

    <script>
        const recipeForm = document.getElementById('create-recipe-form');
        const recipeList = document.getElementById('recipe-list');
        const modal = document.getElementById('recipe-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalDetails = document.getElementById('modal-details');
        const closeModal = document.querySelector('.close');

        let recipeId = 1;

        recipeForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const title = document.getElementById('title').value;
            const author = document.getElementById('author').value;
            const dateCreated = new Date().toLocaleDateString();

            const recipeRow = document.createElement('tr');
            recipeRow.innerHTML = `
                <td>${recipeId++}</td>
                <td>${title}</td>
                <td>${author}</td>
                <td>${dateCreated}</td>
                <td>
                    <button onclick="viewRecipe('${title}')">View</button>
                    <button onclick="confirmDelete(this)">Delete</button>
                </td>
            `;
            recipeList.appendChild(recipeRow);
            recipeForm.reset();
        });

        function viewRecipe(title) {
            modalTitle.textContent = title;
            modal.style.display = "block";
        }

        closeModal.onclick = function() {
            modal.style.display = "none";
        };

        function confirmDelete(button) {
            if (confirm("Are you sure?")) {
                recipeList.removeChild(button.parentElement.parentElement);
            }
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    </script>
</body>
</html>