<?php
session_start();
include '../db.php';

if ($_SESSION['role'] !== 'guru') {
    header("Location: ../index.php");
    exit();
}

// Fungsi untuk mengunggah dan memproses foto siswa
function uploadStudentPhoto($file) {
    $target_dir = "../uploads/"; // Direktori tempat menyimpan foto
    $file_name = time() . "_" . basename($file["name"]); // Menggunakan timestamp untuk nama unik
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($file["tmp_name"]);

    // Validasi apakah file adalah gambar
    if ($check === false) {
        return "File bukan gambar.";
    }

    // Cek tipe file yang diizinkan
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        return "Hanya file JPG, JPEG, dan PNG yang diperbolehkan.";
    }

    // Upload file ke server
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $file_name;
    } else {
        return "Terjadi kesalahan saat mengunggah file.";
    }
}

// Handle form submission for creating a new student
if (isset($_POST['create_student'])) {
    $nis = $_POST['nis'];
    $student_name = $_POST['student_name'];
    $student_class = $_POST['student_class'];
    $gender = $_POST['gender'];
    $place_of_birth = $_POST['place_of_birth'];
    $date_of_birth = $_POST['date_of_birth'];
    $religion = $_POST['religion'];
    $previous_education = $_POST['previous_education'];
    $student_address = $_POST['student_address'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $father_job = $_POST['father_job'];
    $mother_job = $_POST['mother_job'];
    $parent_address = $_POST['parent_address'];
    $guardian_name = $_POST['guardian_name'];
    $guardian_job = $_POST['guardian_job'];
    $guardian_address = $_POST['guardian_address'];
    $photo_name = uploadStudentPhoto($_FILES['student_photo']); // Proses unggah foto

    if (!empty($photo_name) && strpos($photo_name, "Terjadi kesalahan") === false && strpos($photo_name, "File bukan gambar") === false && strpos($photo_name, "Hanya file") === false) {
        $sql = "INSERT INTO students (nis, student_name, student_class, gender, place_of_birth, date_of_birth, religion, previous_education, student_address, father_name, mother_name, parent_address, guardian_name, guardian_job, guardian_address, photo) 
                VALUES ('$nis', '$student_name', '$student_class', '$gender', '$place_of_birth', '$date_of_birth', '$religion', '$previous_education', '$student_address', '$father_name', '$mother_name', '$parent_address', '$guardian_name', '$guardian_job', '$guardian_address', '$photo_name')";
        if ($conn->query($sql) === TRUE) {
            $message = "Siswa berhasil ditambahkan!";
        } else {
            $error = "Error saat menambahkan siswa: " . $conn->error;
        }
    } else {
        $error = $photo_name;
    }
}

// Handle student deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "SELECT photo FROM students WHERE id = $delete_id";
    $result = $conn->query($delete_sql);
    $row = $result->fetch_assoc();
    if ($row['photo']) {
        unlink("../uploads/" . $row['photo']); // Hapus foto dari server
    }

    $sql = "DELETE FROM students WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        $message = "Siswa berhasil dihapus!";
    } else {
        $error = "Error saat menghapus siswa: " . $conn->error;
    }
}

// Handle form submission for editing an existing student
if (isset($_POST['update_student'])) {
    $edit_id = $_POST['edit_id'];
    $nis = $_POST['nis'];
    $student_name = $_POST['student_name'];
    $student_class = $_POST['student_class'];
    $gender = $_POST['gender'];
    $place_of_birth = $_POST['place_of_birth'];
    $date_of_birth = $_POST['date_of_birth'];
    $religion = $_POST['religion'];
    $previous_education = $_POST['previous_education'];
    $student_address = $_POST['student_address'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $father_job = $_POST['father_job'];
    $mother_job = $_POST['mother_job'];
    $parent_address = $_POST['parent_address'];
    $guardian_name = $_POST['guardian_name'];
    $guardian_job = $_POST['guardian_job'];
    $guardian_address = $_POST['guardian_address'];

    // Cek jika ada foto baru diunggah
    if ($_FILES['student_photo']['name']) {
        $photo_name = uploadStudentPhoto($_FILES['student_photo']);
        if (!empty($photo_name) && strpos($photo_name, "Terjadi kesalahan") === false && strpos($photo_name, "File bukan gambar") === false && strpos($photo_name, "Hanya file") === false) {
            $old_photo_sql = "SELECT photo FROM students WHERE id = $edit_id";
            $result = $conn->query($old_photo_sql);
            $row = $result->fetch_assoc();
            if ($row['photo']) {
                unlink("../uploads/" . $row['photo']);
            }
            $sql = "UPDATE students SET photo='$photo_name' WHERE id=$edit_id";
            $conn->query($sql);
        } else {
            $error = $photo_name;
        }
    }

    $sql = "UPDATE students SET nis='$nis', student_name='$student_name', student_class='$student_class', gender='$gender', place_of_birth='$place_of_birth', date_of_birth='$date_of_birth', religion='$religion', previous_education='$previous_education', student_address='$student_address', father_name='$father_name', mother_name='$mother_name', father_job='$father_job', mother_job='$mother_job', parent_address='$parent_address', guardian_name='$guardian_name', guardian_job='$guardian_job', guardian_address='$guardian_address' 
            WHERE id=$edit_id";
    if ($conn->query($sql) === TRUE) {
        $message = "Siswa berhasil diperbarui!";
    } else {
        $error = "Error saat memperbarui siswa: " . $conn->error;
    }
}

// Handle class filter selection
$selected_class = isset($_GET['class_filter']) ? $_GET['class_filter'] : '';

// Update query to filter students based on selected class
if (!empty($selected_class)) {
    $student_sql = "SELECT * FROM students WHERE student_class = '$selected_class'";
} else {
    $student_sql = "SELECT * FROM students";
}
$student_result = $conn->query($student_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Students</title>
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
                <h1 class="h3 mb-2 text-gray-800">Manage Students</h1>

                <!-- Display success or error messages -->
                <?php if (isset($message)) { echo "<div class='alert alert-success'>$message</div>"; } ?>
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                <!-- Student Creation Form (Formulir Tambah Siswa) -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Siswa Baru</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nis">NIS (Nomor Induk Siswa)</label>
                                <input type="text" name="nis" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="student_name">Nama Peserta Didik</label>
                                <input type="text" name="student_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="student_class">Kelas</label>
                                <select name="student_class" class="form-control" required>
                                    <option value="Class 1">Class 1</option>
                                    <option value="Class 2">Class 2</option>
                                    <option value="Class 3">Class 3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="place_of_birth">Tempat Lahir</label>
                                <input type="text" name="place_of_birth" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Jenis Kelamin</label>
                                <select name="gender" class="form-control" required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="religion">Agama</label>
                                <input type="text" name="religion" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="previous_education">Pendidikan Sebelumnya</label>
                                <input type="text" name="previous_education" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="student_address">Alamat Peserta Didik</label>
                                <textarea name="student_address" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="father_name">Nama Orang Tua (Ayah)</label>
                                <input type="text" name="father_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="mother_name">Nama Orang Tua (Ibu)</label>
                                <input type="text" name="mother_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="father_job">Pekerjaan Orang Tua (Ayah)</label>
                                <input type="text" name="mother_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="mother_job">Pekerjaan Orang Tua (Ibu)</label>
                                <input type="text" name="mother_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="parent_address">Alamat Orang Tua</label>
                                <textarea name="parent_address" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="guardian_name">Nama Wali</label>
                                <input type="text" name="guardian_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="guardian_job">Pekerjaan Wali</label>
                                <input type="text" name="guardian_job" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="guardian_address">Alamat Wali</label>
                                <textarea name="guardian_address" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="student_photo">Foto Siswa (JPG, JPEG, PNG)</label>
                                <input type="file" name="student_photo" class="form-control" accept=".jpg, .jpeg, .png">
                            </div>
                            <button type="submit" name="create_student" class="btn btn-primary">Tambahkan Siswa</button>
                        </form>
                    </div>
                </div>

                <!-- Filter Kelas -->
                <div class="mb-4">
                    <form method="GET" action="manage_students.php" class="form-inline">
                        <label for="class_filter" class="mr-2">Filter Kelas:</label>
                        <select name="class_filter" id="class_filter" class="form-control mr-2" onchange="this.form.submit()">
                            <option value="">Semua Kelas</option>
                            <option value="Class 1" <?php if($selected_class == 'Class 1') echo 'selected'; ?>>Class 1</option>
                            <option value="Class 2" <?php if($selected_class == 'Class 2') echo 'selected'; ?>>Class 2</option>
                            <option value="Class 3" <?php if($selected_class == 'Class 3') echo 'selected'; ?>>Class 3</option>
                        </select>
                    </form>
                </div>

                <!-- Tabel Daftar Siswa -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Foto</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Tempat, Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Agama</th>
                                        <th>Pendidikan Sebelumnya</th>
                                        <th>Alamat Peserta Didik</th>
                                        <th>Nama Orang Tua (Ayah)</th>
                                        <th>Nama Orang Tua (Ibu)</th>
                                        <th>Pekerjaan Orang Tua (Ayah)</th>
                                        <th>Pekerjaan Orang Tua (Ibu)</th>
                                        <th>Alamat Orang Tua</th>
                                        <th>Nama Wali</th>
                                        <th>Pekerjaan Wali</th>
                                        <th>Alamat Wali</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $student_result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                                            <td>
                                                <img src="../uploads/<?php echo htmlspecialchars($row['photo']); ?>" width="50" height="67">
                                            </td>
                                            <td><?php echo htmlspecialchars($row['nis']); ?></td>
                                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['student_class']); ?></td>
                                            <td><?php echo htmlspecialchars($row['place_of_birth']) . ', ' . htmlspecialchars($row['date_of_birth']); ?></td>
                                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                            <td><?php echo htmlspecialchars($row['religion']); ?></td>
                                            <td><?php echo htmlspecialchars($row['previous_education']); ?></td>
                                            <td><?php echo htmlspecialchars($row['student_address']); ?></td>
                                            <td><?php echo htmlspecialchars($row['father_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['mother_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['father_job']); ?></td>
                                            <td><?php echo htmlspecialchars($row['mother_job']); ?></td>
                                            <td><?php echo htmlspecialchars($row['parent_address']); ?></td>
                                            <td><?php echo htmlspecialchars($row['guardian_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['guardian_job']); ?></td>
                                            <td><?php echo htmlspecialchars($row['guardian_address']); ?></td>
                                            <td>
                                                <a href="manage_students.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="manage_students.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Formulir Edit Siswa -->
                <?php if (isset($_GET['edit_id'])): 
                    $edit_id = $_GET['edit_id'];
                    $edit_sql = "SELECT * FROM students WHERE id=$edit_id";
                    $edit_result = $conn->query($edit_sql);
                    $edit_student = $edit_result->fetch_assoc();
                ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Siswa</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="edit_id" value="<?php echo $edit_student['id']; ?>">
                            <div class="form-group">
                                <label for="nis">NIS (Nomor Induk Siswa)</label>
                                <input type="text" name="nis" class="form-control" value="<?php echo htmlspecialchars($edit_student['nis']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="student_name">Nama Peserta Didik</label>
                                <input type="text" name="student_name" class="form-control" value="<?php echo htmlspecialchars($edit_student['student_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="student_class">Kelas</label>
                                <select name="student_class" class="form-control" required>
                                    <option value="Class 1" <?php if($edit_student['student_class'] == 'Class 1') echo 'selected'; ?>>Class 1</option>
                                    <option value="Class 2" <?php if($edit_student['student_class'] == 'Class 2') echo 'selected'; ?>>Class 2</option>
                                    <option value="Class 3" <?php if($edit_student['student_class'] == 'Class 3') echo 'selected'; ?>>Class 3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="place_of_birth">Tempat Lahir</label>
                                <input type="text" name="place_of_birth" class="form-control" value="<?php echo htmlspecialchars($edit_student['place_of_birth']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($edit_student['date_of_birth']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Jenis Kelamin</label>
                                <select name="gender" class="form-control" required>
                                    <option value="Laki-laki" <?php if($edit_student['gender'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                                    <option value="Perempuan" <?php if($edit_student['gender'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="religion">Agama</label>
                                <input type="text" name="religion" class="form-control" value="<?php echo htmlspecialchars($edit_student['religion']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="previous_education">Pendidikan Sebelumnya</label>
                                <input type="text" name="previous_education" class="form-control" value="<?php echo htmlspecialchars($edit_student['previous_education']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="student_address">Alamat Peserta Didik</label>
                                <textarea name="student_address" class="form-control" required><?php echo htmlspecialchars($edit_student['student_address']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="father_name">Nama Orang Tua (Ayah)</label>
                                <input type="text" name="father_name" class="form-control" value="<?php echo htmlspecialchars($edit_student['father_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="mother_name">Nama Orang Tua (Ibu)</label>
                                <input type="text" name="mother_name" class="form-control" value="<?php echo htmlspecialchars($edit_student['mother_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="father_job">Pekerjaan Orang Tua (Ayah)</label>
                                <input type="text" name="father_job" class="form-control" value="<?php echo htmlspecialchars($edit_student['father_job']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="mother_job">Pekerjaan Orang Tua (Ibu)</label>
                                <input type="text" name="mother_job" class="form-control" value="<?php echo htmlspecialchars($edit_student['mother_job']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="parent_address">Alamat Orang Tua</label>
                                <textarea name="parent_address" class="form-control" required><?php echo htmlspecialchars($edit_student['parent_address']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="guardian_name">Nama Wali</label>
                                <input type="text" name="guardian_name" class="form-control" value="<?php echo htmlspecialchars($edit_student['guardian_name']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="guardian_job">Pekerjaan Wali</label>
                                <input type="text" name="guardian_job" class="form-control" value="<?php echo htmlspecialchars($edit_student['guardian_job']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="guardian_address">Alamat Wali</label>
                                <textarea name="guardian_address" class="form-control"><?php echo htmlspecialchars($edit_student['guardian_address']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="student_photo">Foto Siswa (JPG, JPEG, PNG)</label>
                                <input type="file" name="student_photo" class="form-control" accept=".jpg, .jpeg, .png">
                                <?php if($edit_student['photo']): ?>
                                    <img src="../uploads/<?php echo htmlspecialchars($edit_student['photo']); ?>" width="50" height="67">
                                    <p>Foto Saat Ini</p>
                                <?php endif; ?>
                            </div>
                            <button type="submit" name="update_student" class="btn btn-success">Update Siswa</button>
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
