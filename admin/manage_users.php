<?php
session_start();
include '../db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle form submission for creating a new user
if (isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        $message = "User successfully created!";
    } else {
        $error = "Error creating user: " . $conn->error;
    }
}

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Hapus dulu data yang terkait di tabel subjects
    $delete_subjects_sql = "DELETE FROM subjects WHERE teacher_id = $delete_id";
    $conn->query($delete_subjects_sql); // Menghapus data terkait di tabel subjects

    // Setelah menghapus data terkait, hapus user
    $sql = "DELETE FROM users WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        $message = "User and related subjects successfully deleted!";
    } else {
        $error = "Error deleting user: " . $conn->error;
    }
}


// Handle user update
if (isset($_POST['update_user'])) {
    $edit_id = $_POST['edit_id'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? md5($_POST['password']) : '';
    $role = $_POST['role'];

    // Update query, only change password if provided
    $sql = "UPDATE users SET username='$username', role='$role'";
    if ($password !== '') {
        $sql .= ", password='$password'";
    }
    $sql .= " WHERE id=$edit_id";

    if ($conn->query($sql) === TRUE) {
        $message = "User successfully updated!";
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Users</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">

<div id="wrapper">
    <?php include 'sidebar.php'; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include 'topbar.php'; ?>

            <div class="container-fluid">
                <h1 class="h3 mb-2 text-gray-800">Manage Users</h1>

                <!-- Display success or error messages -->
                <?php if (isset($message)) { echo "<div class='alert alert-success'>$message</div>"; } ?>
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                <!-- User Creation Form -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Create New User</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" class="form-control" required>
                                    <option value="admin">Admin</option>
                                    <option value="guru">Guru</option>
                                    <option value="wali_kelas">Wali Kelas</option>
                                </select>
                            </div>
                            <button type="submit" name="create_user" class="btn btn-primary">Create User</button>
                        </form>
                    </div>
                </div>

                <!-- User Management Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Users</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['role']; ?></td>
                                            <td>
                                                <a href="manage_users.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="manage_users.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Edit User Form -->
                <?php if (isset($_GET['edit_id'])): 
                    $edit_id = $_GET['edit_id'];
                    $sql = "SELECT * FROM users WHERE id=$edit_id";
                    $edit_result = $conn->query($sql);
                    $edit_user = $edit_result->fetch_assoc();
                ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <input type="hidden" name="edit_id" value="<?php echo $edit_user['id']; ?>">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $edit_user['username']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password (Leave blank if not changing)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" class="form-control" required>
                                    <option value="admin" <?php if($edit_user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                                    <option value="guru" <?php if($edit_user['role'] == 'guru') echo 'selected'; ?>>Guru</option>
                                    <option value="wali_kelas" <?php if($edit_user['role'] == 'wali_kelas') echo 'selected'; ?>>Wali Kelas</option>
                                </select>
                            </div>
                            <button type="submit" name="update_user" class="btn btn-success">Update User</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </div>
</div>

<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sb-admin-2.min.js"></script>

</body>
</html>
