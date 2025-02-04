<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'database.php'; 
require 'partial/header.php'; 
require_once 'partial/nav.php';
?>

<div class="container">
    <h1>User Profile Management</h1>
    <div class="d-flex justify-content-center align-items-center mb-4">
        <a href="create-profile.php" class="btn btn-primary btn-sm">Add Profile</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>S.N.</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Profile Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Fetching all records from the "users" table
                $db = new Database();
                $users = $db->select("SELECT * FROM users");
                $i = 1; // Initialize the counter variable for the serial number
                foreach ($users as $user): ?>
                    <tr>
                        <td><?= $i++; ?></td> 
                        <td><?= $user['first_name']; ?></td> 
                        <td><?= $user['last_name']; ?></td> 
                        <td><?= $user['email']; ?></td> 
                        <td><?= $user['phone_number']; ?></td> 
                        <td>
                            <?php if ($user['profile_photo']): ?>
                                <img src="<?= $user['profile_photo']; ?>" alt="Profile Photo" width="50" height="50" class="img-thumbnail">
                            <?php else: ?>
                                <span>No Photo</span>
                            <?php endif; ?>
                        </td> <!-- Display profile photo -->
                        <td>
                            <!-- Update Profile -->
                            <a href="update-profile.php?id=<?= $user['id']; ?>" class="btn btn-primary btn-sm">Update</a>

                            <!-- Delete Profile -->
                            <form method="POST" action="delete-profile.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="user-info">
                <p class="d-inline">Logged in as: <?= $_SESSION['user_name'] ?? 'N/A'; ?></p>
                <a href="logout.php" class="btn btn-secondary btn-sm d-inline">Logout</a>
            </div>
        </div>
    </div>
</div>

<?php require 'partial/footer.php'; // Include your footer file ?>
