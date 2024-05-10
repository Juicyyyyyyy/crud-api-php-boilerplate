<?php
use App\Models\User;

// Check if an ID was passed and is numeric
$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;

// Redirect if the ID is not valid
if (!$userId) {
    header('Location: users.php');
    exit;
}

// Attempt to delete the user
if (User::delete($userId)) {
    // Optional: Set a success message in session or similar
    $_SESSION['message'] = 'User deleted successfully';
} else {
    // Optional: Set an error message in session or similar
    $_SESSION['error'] = 'Failed to delete user';
}

// Redirect to the user list
header('Location: users.php');
exit;
