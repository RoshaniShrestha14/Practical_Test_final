<?php
require_once 'database.php'; // Include your database connection file
require_once 'partial/header.php'; // Include your header file
require_once 'partial/nav.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $profile_photo = $_FILES['profile_photo'] ?? null;

    // Handle file upload for profile photo
    if ($profile_photo && $profile_photo['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = uniqid() . '_' . basename($profile_photo['name']);
        $file_path = $upload_dir . $file_name;

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        move_uploaded_file($profile_photo['tmp_name'], $file_path);
    } else {
        $file_path = null; // No profile photo uploaded
    }

    if ($first_name && $last_name && $email && $phone_number) {
        $conn = new Database();
        $returnData = $conn->create(
            "INSERT INTO users (first_name, last_name, email, phone_number, profile_photo) VALUES (?, ?, ?, ?, ?)",
            [$first_name, $last_name, $email, $phone_number, $file_path]
        );

        // Redirect to the profile page after successful creation
        header("Location: home.php");
        exit;
    } else {
        // Error handling if fields are missing
        $_SESSION['error'] = "All fields are required!";
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Create Profile</h1>

            <!-- Display the error message if it's set in the session -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['error']); ?> <!-- Clear the error message after displaying it -->
            <?php endif; ?>

            <form method="POST" action="create-profile.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                </div>
                <div class="form-group">
                    <label for="profile_photo">Profile Photo</label>
                    <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Create Profile</button>
                <button type="button" class="btn btn-warning btn-back" onclick="window.history.back();">Go Back</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'partial/footer.php'; ?>
