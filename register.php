<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
    require_once 'database.php';

    // Get form data
    $name = trim($_POST['name']); 
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate form data
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) { // Check if password and confirm password match
        $error = "Passwords do not match.";
    } else {
        $conn = new Database();
        // Check if email already exists as email must be unique for each user
        $sql = "SELECT id FROM users1 WHERE email = ?";
        $count = $conn->countRows($sql, [$email]);
        if ($count > 0) {
                $error = "This email is already registered.";
        } else {
            // Insert new user into database
            $sql = "INSERT INTO users1 (name, email, password) VALUES (?, ?, ?)";
            $hashed_password = sha1(md5($password)); 
            $returnId = $conn->create($sql, [$name, $email, $hashed_password]);
            if ($returnId) { 
                header("Location: login.php");
                exit();
            } else {
                $error = "Something went wrong. Please try again later.";
            
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #c9e9d2, #789dbc);
            font-family: 'Arial', sans-serif;
        }
        .register-container {
            margin-top: 50px;
        }
        .register-form {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .register-form h2 {
            font-weight: bold;
            color: #789dbc;
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 600;
            color: #555555;
        }
        .form-control {
            border: 1px solid #789dbc;
            border-radius: 8px;
        }
        .form-control:focus {
            border-color: #c9e9d2;
            box-shadow: 0 0 5px rgba(201, 233, 210, 0.8);
        }
        .btn-primary {
            background: #789dbc;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #56708f;
        }
        .text-center a {
            color: #789dbc;
            font-weight: bold;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
    </style>
</head>
<body>
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register-form">
                    <h2 class="text-center">Register</h2>
                    <!-- The form is submitted to the same page. You can also use `register.php` on the action. -->
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    <p class="text-center mt-3">
                        Already have an account? <a href="login.php">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>