<?php

require_once 'database.php';


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

  
    $conn = new Database();

   
    $conn->delete("DELETE FROM users WHERE id = ?", [$user_id]);

   
    header("Location: index.php"); 
    exit;
} else {
    echo "No user ID provided.";

    echo '<script type="text/javascript">
            alert("Error: No user ID provided.");
          </script>';
}
?>
