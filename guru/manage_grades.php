<?php
session_start();
include '../db.php';

if ($_SESSION['role'] !== 'guru') {
    header("Location: ../index.php");
    exit();
}

$message = '';
$error = '';

// Handle saving grades
if (isset($_POST['save_grades'])) {
    $student_id = $_POST['student_id'];
    $selected_semester = $_POST['semester']; // Ambil semester yang dipilih

    foreach ($_POST['subjects'] as $subject_id => $data) {
        $knowledge_grade = $data['knowledge_grade'];
        $knowledge_predicate = $data['knowledge_predicate'];
        $knowledge_description = $data['knowledge_description'];
        $skill_grade = $data['skill_grade'];
        $skill_predicate = $data['skill_predicate'];
        $skill_description = $data['skill_description'];

        // Update atau insert nilai
        $check_sql = "SELECT * FROM grades WHERE student_id = '$student_id' AND subject_id = '$subject_id' AND semester = '$selected_semester'";
        $check_result = $conn->query($check_sql);

        if ($check_result && $check_result->num_rows > 0) {
            // Update jika sudah ada nilai
            $update_sql = "UPDATE grades 
                           SET knowledge_grade = '$knowledge_grade', knowledge_predicate = '$knowledge_predicate', knowledge_description = '$knowledge_description',
                               skill_grade = '$skill_grade', skill_predicate = '$skill_predicate', skill_description = '$skill_description'
                           WHERE student_id = '$student_id' AND subject_id = '$subject_id' AND semester = '$selected_semester'";
            $conn->query($update_sql);
        } else {
            // Insert nilai baru
            $insert_sql = "INSERT INTO grades (student_id, subject_id, semester, knowledge_grade, knowledge_predicate, knowledge_description, skill_grade, skill_predicate, skill_description) 
                           VALUES ('$student_id', '$subject_id', '$selected_semester', '$knowledge_grade', '$knowledge_predicate', '$knowledge_description', '$skill_grade', '$skill_predicate', '$skill_description')";
            $conn->query($insert_sql);
        }
    }

    $message = "Grades saved successfully!";
}

// Handle class, student, and semester filters
$selected_class = '';
$selected_student = '';
$selected_semester = '';
$students_result = null;
$subjects_result = null;

if (isset($_POST['filter_class'])) {
    $selected_class = $_POST['selected_class'];
    $selected_semester = $_POST['semester'];

    // Fetch students based on selected class
    $students_sql = "SELECT * FROM students WHERE student_class = '$selected_class'";
    $students_result = $conn->query($students_sql);
}

if (isset($_POST['filter_student'])) {
    $selected_class = $_POST['selected_class'];
    $selected_student = $_POST['student_id'];
    $selected_semester = $_POST['semester'];

    // Fetch subjects for selected student
    $subjects_sql = "SELECT * FROM subjects";
    $subjects_result = $conn->query($subjects_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Grades</title>
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
                <h1 class="h3 mb-2 text-gray-800">Manage Nilai</h1>

                <!-- Display success or error messages -->
                <?php if ($message) { echo "<div class='alert alert-success'>$message</div>"; } ?>
                <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                <!-- Filter by Class -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Filter Siswa Berdasarkan Kelas dan Semester</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="selected_class">Pilih Kelas</label>
                                <select name="selected_class" class="form-control" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="Class 1" <?php if ($selected_class == 'Class 1') echo 'selected'; ?>>Class 1</option>
                                    <option value="Class 2" <?php if ($selected_class == 'Class 2') echo 'selected'; ?>>Class 2</option>
                                    <option value="Class 3" <?php if ($selected_class == 'Class 3') echo 'selected'; ?>>Class 3</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="semester">Pilih Semester</label>
                                <select name="semester" class="form-control" required>
                                    <option value="">Pilih Semester</option>
                                    <option value="ganjil" <?php if ($selected_semester == 'ganjil') echo 'selected'; ?>>Ganjil</option>
                                    <option value="genap" <?php if ($selected_semester == 'genap') echo 'selected'; ?>>Genap</option>
                                </select>
                            </div>

                            <button type="submit" name="filter_class" class="btn btn-primary">Filter Kelas</button>
                        </form>
                    </div>
                </div>

                <!-- Tabel untuk menampilkan siswa dan status input nilai -->
                <?php if ($students_result && $students_result->num_rows > 0): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($student = $students_result->fetch_assoc()) { 
                                        $student_id = $student['id'];

                                        // Cek apakah sudah ada nilai untuk semua mata pelajaran di semester ini
                                        $all_grades_filled = true;
                                        $subject_missing = []; // Array untuk menyimpan nama mata pelajaran yang belum lengkap
                                        
                                        $check_grade_sql = "SELECT s.subject_name, g.knowledge_grade, g.knowledge_predicate, g.knowledge_description,
                                                                   g.skill_grade, g.skill_predicate, g.skill_description
                                                            FROM subjects s 
                                                            LEFT JOIN grades g ON s.id = g.subject_id AND g.student_id = '$student_id' AND g.semester = '$selected_semester'";
                                        $check_grade_result = $conn->query($check_grade_sql);

                                        while ($row = $check_grade_result->fetch_assoc()) {
                                            if (empty($row['knowledge_grade']) || empty($row['knowledge_predicate']) || empty($row['knowledge_description']) ||
                                                empty($row['skill_grade']) || empty($row['skill_predicate']) || empty($row['skill_description'])) {
                                                $all_grades_filled = false;
                                                $subject_missing[] = $row['subject_name'];  // Simpan nama mata pelajaran yang belum lengkap
                                            }
                                        }

                                        ?>
                                        <tr>
                                            <td><?php echo $student['student_name']; ?></td>
                                            <td>
                                                <?php if ($check_grade_result->num_rows == 0): ?>
                                                    <span class="badge badge-warning">Belum diinput</span>
                                                <?php elseif (empty($subject_missing)): ?>
                                                    <span class="badge badge-success">Sudah diinput semua nilai</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Belum diinput semua nilai</span>
                                                    <ul>
                                                        <?php foreach ($subject_missing as $subject): ?>
                                                            <li><?php echo $subject; ?> belum diinput</li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <!-- Tombol untuk mengupdate atau menginput nilai -->
                                                <form method="POST" action="">
                                                    <input type="hidden" name="selected_class" value="<?php echo $selected_class; ?>">
                                                    <input type="hidden" name="semester" value="<?php echo $selected_semester; ?>">
                                                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                                                    <button type="submit" name="filter_student" class="btn btn-primary">
                                                        <?php echo $check_grade_result->num_rows > 0 ? 'Update Nilai' : 'Input Nilai'; ?>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Form input nilai siswa -->
                <?php if ($subjects_result && $subjects_result->num_rows > 0): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Input Nilai Siswa</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <input type="hidden" name="student_id" value="<?php echo $selected_student; ?>">
                                <input type="hidden" name="semester" value="<?php echo $selected_semester; ?>">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mata Pelajaran</th>
                                            <th>Nilai Pengetahuan</th>
                                            <th>Predikat Pengetahuan</th>
                                            <th>Deskripsi Pengetahuan</th>
                                            <th>Nilai Keterampilan</th>
                                            <th>Predikat Keterampilan</th>
                                            <th>Deskripsi Keterampilan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($subject = $subjects_result->fetch_assoc()) {
                                            $subject_id = $subject['id'];
                                            // Fetch existing grades
                                            $grade_sql = "SELECT * FROM grades WHERE student_id = '$selected_student' AND subject_id = '$subject_id' AND semester = '$selected_semester'";
                                            $grade_result = $conn->query($grade_sql);
                                            $grade = $grade_result ? $grade_result->fetch_assoc() : null;
                                            ?>
                                            <tr>
                                                <td><?php echo $subject['subject_name']; ?></td>

                                                <!-- Nilai Pengetahuan -->
                                                <td><input type="text" name="subjects[<?php echo $subject_id; ?>][knowledge_grade]" class="form-control" value="<?php echo $grade ? $grade['knowledge_grade'] : ''; ?>"></td>
                                                <td>
                                                    <select name="subjects[<?php echo $subject_id; ?>][knowledge_predicate]" class="form-control">
                                                        <option value="A" <?php echo $grade && $grade['knowledge_predicate'] == 'A' ? 'selected' : ''; ?>>A</option>
                                                        <option value="B" <?php echo $grade && $grade['knowledge_predicate'] == 'B' ? 'selected' : ''; ?>>B</option>
                                                        <option value="C" <?php echo $grade && $grade['knowledge_predicate'] == 'C' ? 'selected' : ''; ?>>C</option>
                                                        <option value="D" <?php echo $grade && $grade['knowledge_predicate'] == 'D' ? 'selected' : ''; ?>>D</option>
                                                    </select>
                                                </td>
                                                <td><textarea name="subjects[<?php echo $subject_id; ?>][knowledge_description]" class="form-control"><?php echo $grade ? $grade['knowledge_description'] : ''; ?></textarea></td>

                                                <!-- Nilai Keterampilan -->
                                                <td><input type="text" name="subjects[<?php echo $subject_id; ?>][skill_grade]" class="form-control" value="<?php echo $grade ? $grade['skill_grade'] : ''; ?>"></td>
                                                <td>
                                                    <select name="subjects[<?php echo $subject_id; ?>][skill_predicate]" class="form-control">
                                                        <option value="A" <?php echo $grade && $grade['skill_predicate'] == 'A' ? 'selected' : ''; ?>>A</option>
                                                        <option value="B" <?php echo $grade && $grade['skill_predicate'] == 'B' ? 'selected' : ''; ?>>B</option>
                                                        <option value="C" <?php echo $grade && $grade['skill_predicate'] == 'C' ? 'selected' : ''; ?>>C</option>
                                                        <option value="D" <?php echo $grade && $grade['skill_predicate'] == 'D' ? 'selected' : ''; ?>>D</option>
                                                    </select>
                                                </td>
                                                <td><textarea name="subjects[<?php echo $subject_id; ?>][skill_description]" class="form-control"><?php echo $grade ? $grade['skill_description'] : ''; ?></textarea></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <button type="submit" name="save_grades" class="btn btn-primary">Simpan Nilai</button>
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

