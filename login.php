<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'database.php';
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new Database();

    // Check if user exists
    $sql = "SELECT * FROM users1 WHERE email = ? AND password = ?";
    $hashed_password = sha1(md5($password)); 
    $result = $conn->select($sql, [$email, $hashed_password]);
    if (!empty($result) && count($result) === 1) { // Check if the result is not empty and only one user is found
        $user = $result[0];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: home.php"); 
        exit();
    } else {
        $_SESSION['error'] = "Invalid Credentials."; 
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
</head>
<body>
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register-form">
                    <h2 class="text-center">Login</h2>
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <p class="text-center mt-3">
                        Don't have an account? <a href="register.php">Register here</a>
                    </p>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <?= $_SESSION['error']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>