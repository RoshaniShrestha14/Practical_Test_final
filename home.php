<?php
session_start();
require 'partial/header.php';
require 'partial/nav.php';
?>

<div class="container text-center mt-5">
    <h1 class="display-4">Welcome to User Profile Management System</h1>
    <p class="lead">Easily manage user profiles with create, read, update, and delete functionalities.</p>

    <div class="mt-4">
        <a href="index.php" class="btn btn-primary btn-lg m-2">View Profiles</a>
        <a href="create-profile.php" class="btn btn-success btn-lg m-2">Create New Profile</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="btn btn-danger btn-lg m-2">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-warning btn-lg m-2">Login</a>
        <?php endif; ?>
    </div>

    <div class="mt-5">
        <h3>Why Use This System?</h3>
        <ul class="list-unstyled">
            <li>✅ Simple and intuitive interface</li>
            <li>✅ Secure data management</li>
            <li>✅ Quick profile creation and updates</li>
        </ul>
    </div>
</div>

<footer class="text-center mt-5">
    <p>&copy; <?= date('Y'); ?> User Profile Management System. All rights reserved.</p>
</footer>

<?php require 'partial/footer.php'; // Include footer ?>