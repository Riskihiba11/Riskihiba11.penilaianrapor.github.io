<?php
session_start();
include '../db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Get the selected class from the URL
$selected_class = isset($_GET['class']) ? $_GET['class'] : '';

// Fetch students based on the selected class
$students = [];
if ($selected_class !== '') {
    $student_sql = "SELECT * FROM students WHERE student_class = '$selected_class'";
    $student_result = $conn->query($student_sql);
    while ($row = $student_result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Generate Report Card</title>
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
                <h1 class="h3 mb-2 text-gray-800">Generate Report Card for <?php echo $selected_class; ?></h1>

                <!-- Display List of Students for the Selected Class -->
                <?php if (!empty($students)) { ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of Students in <?php echo $selected_class; ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NIS</th>
                                            <th>Name</th>
                                            <th>Class</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $student) { ?>
                                            <tr>
                                                <td><?php echo $student['id']; ?></td>
                                                <td><?php echo $student['nis']; ?></td>
                                                <td><?php echo $student['student_name']; ?></td>
                                                <td><?php echo $student['student_class']; ?></td>
                                                <td>
                                                <form method="post" action="generate_report_pdf.php?student_id=<?php echo $student['id']; ?>&semester=ganjil">
                                                    <input type="text" name="tahun_ajaran" placeholder="Masukkan Tahun Ajaran" required>
                                                    <button type="submit" class="btn btn-primary btn-sm">Ganjil</button>
                                                </form>

                                                <form method="post" action="generate_report_pdf.php?student_id=<?php echo $student['id']; ?>&semester=genap">
                                                    <input type="text" name="tahun_ajaran" placeholder="Masukkan Tahun Ajaran" required>
                                                    <button type="submit" class="btn btn-success btn-sm">Genap</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning" role="alert">
                        No students found for the selected class.
                    </div>
                <?php } ?>
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
