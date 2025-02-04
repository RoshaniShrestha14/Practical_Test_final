<?php
require_once 'database.php'; // Include your database connection file
require_once 'partial/header.php'; // Include your header file
require_once 'partial/nav.php';

if ($_GET['id']) {
    $id = $_GET['id'];
    $conn = new Database();

    // Fetch user data by user_id (assuming the table is 'users' and the ID is 'id')
    $user = $conn->select("SELECT * FROM users WHERE id = ?", [$id]);

    // Get only the first element of the array (assuming there is only one user with that ID)
    $user = $user[0] ?? null;

    if (!$user) {
        die("User not found.");
    }
}

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
        $file_path = $user['profile_photo'] ?? null; // Keep the existing photo if no new photo is uploaded
    }

    // Validate if all fields are provided
    if ($first_name && $last_name && $email && $phone_number) {
        $conn = new Database();

        // Update user profile data in the database
        $returnData = $conn->update(
            "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ?, profile_photo = ? WHERE id = ?", 
            [$first_name, $last_name, $email, $phone_number, $file_path, $id]
        );

        // Redirect to a profile page (or index, based on your preference)
        header("Location: index.php?id=$id");
        exit;
    } else {
        // Display error message in an alert box
        $_SESSION['error'] = "All fields are required!";
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Update Profile - <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?? ''; ?></h1>

            <!-- Display the error message if it's set in the session -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST" action="update-profile.php?id=<?= $id ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user['phone_number'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="profile_photo">Profile Photo</label>
                    <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*">
                    <?php if (!empty($user['profile_photo'])): ?>
                        <img src="<?= $user['profile_photo'] ?>" alt="Profile Photo" class="img-thumbnail mt-2" width="150">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
                <button type="button" class="btn btn-warning btn-back" onclick="window.history.back();">Go Back</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'partial/footer.php'; ?>
