// Existing checkPassword function with added alerts for incorrect input
function checkPassword() {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let isValid = true;
    let message = "";

    // Email validation using regex for proper format
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        isValid = false;
        message += "Please enter a valid email address (for example, user@example.com).\n";
    }

    // Password validation: Check if password is at least 8 characters long
    if (password.length < 8) {
        isValid = false;
        message += "Password must be at least 8 characters long.\n";
    }

    // Check for at least one uppercase letter
    if (!/[A-Z]/.test(password)) {
        isValid = false;
        message += "Password must contain at least one uppercase letter.\n";
    }

    // Check for at least one lowercase letter
    if (!/[a-z]/.test(password)) {
        isValid = false;
        message += "Password must contain at least one lowercase letter.\n";
    }

    // Check for at least one number
    if (!/[0-9]/.test(password)) {
        isValid = false;
        message += "Password must contain at least one number.\n";
    }

    // Check for at least one special character
    if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        isValid = false;
        message += "Password must contain at least one special character.\n";
    }

    // Display result
    if (isValid) {
        alert("Login successful!");
        document.getElementById("errorMessage").textContent = "";
    } else {
        alert(message);
        document.getElementById("errorMessage").textContent = message;
        document.getElementById("errorMessage").style.color = "red";
    }

    return isValid;
}

// Validate Register Form Function
function validateForm() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;

    // Simple Email Format Validation
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    if (!name) {
        alert('Name is required');
        return false;
    }

    if (!emailPattern.test(email)) {
        alert('Invalid email format (for example, user@example.com).');
        return false;
    }

    return true;
}

// Confirm Delete function (showing custom modal)
function confirmDelete(userId) {
    // Show the modal when delete button is clicked
    const modal = document.getElementById("confirmDeleteModel");
    modal.style.display = "block";

    // Set up the modal message
    document.getElementById("deleteMessage").textContent = "Are you sure you want to delete user " + userId + "?";

    // Set up event listeners for Yes and No buttons
    document.getElementById("confirmYes").onclick = function() {
        alert('User ' + userId + ' deleted.');
        closeModal(); // Close the modal after confirming
        // Add any further actions like removing the user from a table or database here.
    };

    document.getElementById("confirmNo").onclick = function() {
        closeModal(); // Simply close the modal if they click No
    };
}

// Close Modal Function
function closeModal() {
    document.getElementById("confirmDeleteModel").style.display = "none";
}

// View More Function (fetches user details)
function viewMore(userId) {
    // Simulating fetching additional user details
    let userDetails = '';
    switch (userId) {
        case 1:
            userDetails = 'Name: Abigail Yeboah \nEmail: abigailyeboah@gmail.com\nRole: Admin';
            break;
        case 2:
            userDetails = 'Name: John Amuzu \nEmail: johnamuzu@gmail.com\nRole: User';
            break;
        case 3:
            userDetails = 'Name: Akwesi Doe \nEmail: akwesidoe@yahoo.com\nRole: User';
            break;
        default:
            userDetails = 'User not found.';
    }

    document.getElementById("userDetails").innerText = userDetails;
    document.getElementById("userModal").style.display = "block"; // Show the modal
}

// Close User Details Modal
function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

// Update User Function (placeholder)
function updateUser(userId) {
    alert('Update user functionality for user ID ' + userId + ' is not implemented yet.');
}

// Attach validation function to form submit event
document.getElementById("registerForm").onsubmit = function() {
    return validateForm();
};

// Add event listeners for buttons
document.querySelectorAll('.read').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.getAttribute('onclick').match(/\d+/)[0]; // Extract user ID from onclick
        viewMore(userId); // Call viewMore with user ID
    });
});

document.querySelectorAll('.update').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.getAttribute('onclick').match(/\d+/)[0]; // Extract user ID from onclick
        updateUser(userId); // Call updateUser with user ID
    });
});

document.querySelectorAll('.delete').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.getAttribute('onclick').match(/\d+/)[0]; // Extract user ID from onclick
        confirmDelete(userId); // Call confirmDelete with user ID
    });
});
// Function to delete a user
function confirmDelete(userId) {
    const modal = document.getElementById('confirmDeleteModal');
    const deleteMessage = document.getElementById('deleteMessage');
    const confirmYes = document.getElementById('confirmYes');
    const confirmNo = document.getElementById('confirmNo');

    deleteMessage.textContent = `Are you sure you want to delete user with ID ${userId}?`;
    modal.style.display = 'block';

    confirmYes.onclick = () => {
        users = users.filter(user => user.id !== userId);
        modal.style.display = 'none';
        loadUsers();
    };

    confirmNo.onclick = () => {
        modal.style.display = 'none';
    };
}

// Function to update a user
function updateUser(userId) {
    const user = users.find(user => user.id === userId);
    const name = prompt('Enter new name:', user.name);
    const email = prompt('Enter new email:', user.email);

    if (name && email && validateEmail(email)) {
        user.name = name;
        user.email = email;
        loadUsers();
    } else if (!validateEmail(email)) {
        alert('Invalid email format');
    }
}

// Function to view more user details
function viewMore(userId) {
    const user = users.find(user => user.id === userId);
    const modal = document.getElementById('userModal');
    const userDetails = document.getElementById('userDetails');

    userDetails.innerHTML = `
        <h3>User Details</h3>
        <p><strong>ID:</strong> ${user.id}</p>
        <p><strong>Name:</strong> ${user.name}</p>
        <p><strong>Email:</strong> ${user.email}</p>
    `;
    modal.style.display = 'block';
}

// Function to close the "View More" modal
function closeUserModal() {
    const modal = document.getElementById('userModal');
    modal.style.display = 'none';
}

// Hide modals when clicking outside of them
window.onclick = function(event) {
    const deleteModal = document.getElementById('confirmDeleteModal');
    const userModal = document.getElementById('userModal');
    if (event.target === deleteModal) {
        deleteModal.style.display = 'none';
    }
    if (event.target === userModal) {
        userModal.style.display = 'none';
    }
};
