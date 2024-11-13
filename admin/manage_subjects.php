<?php
session_start();
include '../db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle form submission for creating a new subject
if (isset($_POST['create_subject'])) {
    $subject_name = $_POST['subject_name'];
    $subject_class = $_POST['subject_class'];
    $teacher_id = $_POST['teacher_id'];

    $sql = "INSERT INTO subjects (subject_name, subject_class, teacher_id) 
            VALUES ('$subject_name', '$subject_class', '$teacher_id')";
    if ($conn->query($sql) === TRUE) {
        $message = "Subject successfully created!";
    } else {
        $error = "Error creating subject: " . $conn->error;
    }
}

// Check if an edit request is made
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_sql = "SELECT * FROM subjects WHERE id = $edit_id";
    $edit_result = $conn->query($edit_sql);
    $edit_subject = $edit_result->fetch_assoc(); // Get the subject details
}

// Handle form submission for updating an existing subject
if (isset($_POST['update_subject'])) {
    $edit_id = $_POST['edit_id'];
    $subject_name = $_POST['subject_name'];
    $subject_class = $_POST['subject_class'];
    $teacher_id = $_POST['teacher_id'];

    // Update the subject in the database
    $sql = "UPDATE subjects SET subject_name='$subject_name', subject_class='$subject_class', teacher_id='$teacher_id' WHERE id=$edit_id";
    if ($conn->query($sql) === TRUE) {
        $message = "Subject successfully updated!";
    } else {
        $error = "Error updating subject: " . $conn->error;
    }
}

// Handle class filter selection
$selected_class = '';
if (isset($_POST['filter_class'])) {
    $selected_class = $_POST['selected_class'];
}

// Fetch all available classes for the dropdown filter
$class_sql = "SELECT DISTINCT subject_class FROM subjects";
$class_result = $conn->query($class_sql);

// Fetch all subjects based on the selected class filter
$subject_sql = "SELECT subjects.*, users.username AS teacher_name FROM subjects 
                LEFT JOIN users ON subjects.teacher_id = users.id";

if ($selected_class !== '') {
    $subject_sql .= " WHERE subjects.subject_class = '$selected_class'";
}

$subject_result = $conn->query($subject_sql);

// Error handling for subject query
if (!$subject_result) {
    die("Error fetching subjects data: " . $conn->error);
}

// Fetch all teachers for the dropdown list in the subject creation form
$teacher_sql = "SELECT * FROM users WHERE role='guru'";
$teacher_result = $conn->query($teacher_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Subjects</title>
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
                <h1 class="h3 mb-2 text-gray-800">Manage Subjects</h1>

                <!-- Display success or error messages -->
                <?php if (isset($message)) { echo "<div class='alert alert-success'>$message</div>"; } ?>
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                <!-- Subject Creation/Editing Form -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php echo isset($edit_subject) ? 'Edit Subject' : 'Create New Subject'; ?>
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <!-- Include the edit ID if we are editing -->
                            <?php if (isset($edit_subject)) { ?>
                                <input type="hidden" name="edit_id" value="<?php echo $edit_subject['id']; ?>">
                            <?php } ?>
                            <div class="form-group">
                                <label for="subject_name">Subject Name</label>
                                <input type="text" name="subject_name" class="form-control" value="<?php echo isset($edit_subject) ? $edit_subject['subject_name'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="subject_class">Class</label>
                                <select name="subject_class" class="form-control" required>
                                    <option value="Class 1" <?php if (isset($edit_subject) && $edit_subject['subject_class'] == 'Class 1') echo 'selected'; ?>>Class 1</option>
                                    <option value="Class 2" <?php if (isset($edit_subject) && $edit_subject['subject_class'] == 'Class 2') echo 'selected'; ?>>Class 2</option>
                                    <option value="Class 3" <?php if (isset($edit_subject) && $edit_subject['subject_class'] == 'Class 3') echo 'selected'; ?>>Class 3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="teacher_id">Teacher</label>
                                <select name="teacher_id" class="form-control" required>
                                    <option value="">Select a Teacher</option>
                                    <?php while ($teacher = $teacher_result->fetch_assoc()) { ?>
                                        <option value="<?php echo $teacher['id']; ?>" <?php if (isset($edit_subject) && $edit_subject['teacher_id'] == $teacher['id']) echo 'selected'; ?>>
                                            <?php echo $teacher['username']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" name="<?php echo isset($edit_subject) ? 'update_subject' : 'create_subject'; ?>" class="btn btn-primary">
                                <?php echo isset($edit_subject) ? 'Update Subject' : 'Create Subject'; ?>
                            </button>
                        </form>
                    </div>
                </div>


                <!-- Subject Management Section -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Subjects</h6>
                    </div>
                    <div class="card-body">

                        <!-- Class Filter Form (Positioned below the List of Subjects header) -->
                        <form method="POST" action="" class="mb-4">
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <label for="selected_class" class="mr-sm-2">Filter by Class:</label>
                                </div>
                                <div class="col-auto">
                                    <select name="selected_class" class="form-control mb-2">
                                        <option value="">All Classes</option>
                                        <?php while ($class = $class_result->fetch_assoc()) { ?>
                                            <option value="<?php echo $class['subject_class']; ?>" 
                                                <?php if ($selected_class === $class['subject_class']) echo 'selected'; ?>>
                                                <?php echo $class['subject_class']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" name="filter_class" class="btn btn-primary mb-2">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Subject Management Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Subject</th>
                                        <th>Class</th>
                                        <th>Teacher</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($subject_result->num_rows > 0): ?>
                                        <?php while ($row = $subject_result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['subject_name']; ?></td>
                                                <td><?php echo $row['subject_class']; ?></td>
                                                <td><?php echo $row['teacher_name']; ?></td>
                                                <td>
                                                    <a href="manage_subjects.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="manage_subjects.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subject?');">Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No subjects found for the selected class.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
