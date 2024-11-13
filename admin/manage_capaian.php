<?php
session_start();
include '../db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle insert or update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $predikat_spiritual = $_POST['predikat_spiritual'];
    $deskripsi_spiritual = $_POST['deskripsi_spiritual'];
    $predikat_sosial = $_POST['predikat_sosial'];
    $deskripsi_sosial = $_POST['deskripsi_sosial'];

    // Cek apakah data capaian untuk siswa sudah ada
    $check_stmt = $conn->prepare("SELECT * FROM capaian_hasil WHERE student_id = ?");
    $check_stmt->bind_param('i', $student_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika data sudah ada, update data
        $stmt = $conn->prepare("UPDATE capaian_hasil SET predikat_spiritual = ?, deskripsi_spiritual = ?, predikat_sosial = ?, deskripsi_sosial = ? WHERE student_id = ?");
        $stmt->bind_param('ssssi', $predikat_spiritual, $deskripsi_spiritual, $predikat_sosial, $deskripsi_sosial, $student_id);
        $stmt->execute();
    } else {
        // Jika belum ada data, lakukan insert
        $stmt = $conn->prepare("INSERT INTO capaian_hasil (student_id, predikat_spiritual, deskripsi_spiritual, predikat_sosial, deskripsi_sosial) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('issss', $student_id, $predikat_spiritual, $deskripsi_spiritual, $predikat_sosial, $deskripsi_sosial);
        $stmt->execute();
    }

    header('Location: manage_capaian.php');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM capaian_hasil WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: manage_capaian.php');
    exit;
}

// Get all students
$students_result = $conn->query("SELECT id, student_name FROM students");

// Get all capaian hasil belajar
$result = $conn->query("SELECT students.student_name, capaian_hasil.* FROM capaian_hasil JOIN students ON capaian_hasil.student_id = students.id");
$capaian_hasil = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $capaian_hasil[] = $row;
    }
}

// Jika ada request edit, ambil data capaian yang akan di-edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM capaian_hasil WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Capaian Hasil Belajar</title>
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
                <h1 class="h3 mb-2 text-gray-800">Manage Capaian Hasil Belajar</h1>

                <!-- Form untuk input data capaian per siswa -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php echo isset($edit_data) ? "Edit Capaian Hasil Belajar" : "Tambah Capaian Hasil Belajar untuk Siswa"; ?>
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="manage_capaian.php">
                            <input type="hidden" name="action" value="<?php echo isset($edit_data) ? 'update' : 'create'; ?>">
                            <?php if (isset($edit_data)): ?>
                                <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                            <?php endif; ?>

                            <div class="form-group">
                                <label>Pilih Siswa</label>
                                <select class="form-control" name="student_id" required <?php echo isset($edit_data) ? 'disabled' : ''; ?>>
                                    <?php while ($student = $students_result->fetch_assoc()): ?>
                                        <option value="<?php echo $student['id']; ?>" <?php echo isset($edit_data) && $edit_data['student_id'] == $student['id'] ? 'selected' : ''; ?>>
                                            <?php echo $student['student_name']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <?php if (isset($edit_data)): ?>
                                    <input type="hidden" name="student_id" value="<?php echo $edit_data['student_id']; ?>">
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Predikat Sikap Spiritual</label>
                                <select class="form-control" name="predikat_spiritual" required>
                                    <option value="A" <?php echo isset($edit_data) && $edit_data['predikat_spiritual'] == 'A' ? 'selected' : ''; ?>>A</option>
                                    <option value="B" <?php echo isset($edit_data) && $edit_data['predikat_spiritual'] == 'B' ? 'selected' : ''; ?>>B</option>
                                    <option value="C" <?php echo isset($edit_data) && $edit_data['predikat_spiritual'] == 'C' ? 'selected' : ''; ?>>C</option>
                                    <option value="D" <?php echo isset($edit_data) && $edit_data['predikat_spiritual'] == 'D' ? 'selected' : ''; ?>>D</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Sikap Spiritual</label>
                                <textarea class="form-control" name="deskripsi_spiritual" required><?php echo isset($edit_data) ? $edit_data['deskripsi_spiritual'] : ''; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Predikat Sikap Sosial</label>
                                <select class="form-control" name="predikat_sosial" required>
                                    <option value="A" <?php echo isset($edit_data) && $edit_data['predikat_sosial'] == 'A' ? 'selected' : ''; ?>>A</option>
                                    <option value="B" <?php echo isset($edit_data) && $edit_data['predikat_sosial'] == 'B' ? 'selected' : ''; ?>>B</option>
                                    <option value="C" <?php echo isset($edit_data) && $edit_data['predikat_sosial'] == 'C' ? 'selected' : ''; ?>>C</option>
                                    <option value="D" <?php echo isset($edit_data) && $edit_data['predikat_sosial'] == 'D' ? 'selected' : ''; ?>>D</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Sikap Sosial</label>
                                <textarea class="form-control" name="deskripsi_sosial" required><?php echo isset($edit_data) ? $edit_data['deskripsi_sosial'] : ''; ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary"><?php echo isset($edit_data) ? 'Update' : 'Simpan'; ?> Capaian</button>
                        </form>
                    </div>
                </div>

                                <!-- Tabel untuk menampilkan data capaian per siswa -->
                                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Capaian Hasil Belajar Siswa</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Predikat Sikap Spiritual</th>
                                        <th>Deskripsi Sikap Spiritual</th>
                                        <th>Predikat Sikap Sosial</th>
                                        <th>Deskripsi Sikap Sosial</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($capaian_hasil as $capaian): ?>
                                        <tr>
                                            <td><?php echo $capaian['student_name']; ?></td>
                                            <td><?php echo $capaian['predikat_spiritual']; ?></td>
                                            <td><?php echo $capaian['deskripsi_spiritual']; ?></td>
                                            <td><?php echo $capaian['predikat_sosial']; ?></td>
                                            <td><?php echo $capaian['deskripsi_sosial']; ?></td>
                                            <td>
                                                <a href="manage_capaian.php?edit=<?php echo $capaian['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="manage_capaian.php?delete=<?php echo $capaian['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
