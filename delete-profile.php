<?php
// Include database connection file
require_once 'database.php';

// Check if the form is submitted via POST method and the user ID is provided
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Create an instance of the database class
    $conn = new Database();

    // Delete the profile from the 'users' table where the user_id matches
    $conn->delete("DELETE FROM users WHERE id = ?", [$user_id]);

    // Redirect to the homepage (or any other page after deletion)
    header("Location: index.php"); // You can change this to the appropriate page
    exit;
} else {
    echo "No user ID provided.";

    // Display the error message in an alert box
    echo '<script type="text/javascript">
            alert("Error: No user ID provided.");
          </script>';
}
?>
