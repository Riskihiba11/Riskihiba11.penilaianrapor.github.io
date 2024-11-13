<?php
session_start();
include '../db.php';

if ($_SESSION['role'] !== 'guru') {
    header("Location: ../index.php");
    exit();
}

$message = '';
$error = '';

// Handle saving extracurricular data
if (isset($_POST['save_ekstrakurikuler'])) {
    $student_id = $_POST['student_id'];

    // Ambil nilai dari form, gunakan operator ternary untuk memeriksa apakah input ada
    $pramuka_predikat = isset($_POST['pramuka_predikat']) ? $_POST['pramuka_predikat'] : '';
    $pramuka_keterangan = isset($_POST['pramuka_keterangan']) ? $_POST['pramuka_keterangan'] : '';
    $silat_predikat = isset($_POST['silat_predikat']) ? $_POST['silat_predikat'] : '';
    $silat_keterangan = isset($_POST['silat_keterangan']) ? $_POST['silat_keterangan'] : '';
    $jurnalistik_predikat = isset($_POST['jurnalistik_predikat']) ? $_POST['jurnalistik_predikat'] : '';
    $jurnalistik_keterangan = isset($_POST['jurnalistik_keterangan']) ? $_POST['jurnalistik_keterangan'] : '';
    $melukis_predikat = isset($_POST['melukis_predikat']) ? $_POST['melukis_predikat'] : '';
    $melukis_keterangan = isset($_POST['melukis_keterangan']) ? $_POST['melukis_keterangan'] : '';
    $futsal_predikat = isset($_POST['futsal_predikat']) ? $_POST['futsal_predikat'] : '';
    $futsal_keterangan = isset($_POST['futsal_keterangan']) ? $_POST['futsal_keterangan'] : '';
    $kir_predikat = isset($_POST['kir_predikat']) ? $_POST['kir_predikat'] : '';
    $kir_keterangan = isset($_POST['kir_keterangan']) ? $_POST['kir_keterangan'] : '';
    $leader_community_predikat = isset($_POST['leader_community_predikat']) ? $_POST['leader_community_predikat'] : '';
    $leader_community_keterangan = isset($_POST['leader_community_keterangan']) ? $_POST['leader_community_keterangan'] : '';
    $english_club_predikat = isset($_POST['english_club_predikat']) ? $_POST['english_club_predikat'] : '';
    $english_club_keterangan = isset($_POST['english_club_keterangan']) ? $_POST['english_club_keterangan'] : '';
    $sakit = isset($_POST['sakit']) ? $_POST['sakit'] : '';
    $ijin = isset($_POST['ijin']) ? $_POST['ijin'] : '';
    $tanpa_kabar = isset($_POST['tanpa_kabar']) ? $_POST['tanpa_kabar'] : '';
    $juz = isset($_POST['juz']) ? $_POST['juz'] : '';
    $surat_tahfizh = isset($_POST['surat_tahfizh']) ? $_POST['surat_tahfizh'] : '';
    $jilid_tahsin = isset($_POST['jilid_tahsin']) ? $_POST['jilid_tahsin'] : '';
    $halaman_tahsin = isset($_POST['halaman_tahsin']) ? $_POST['halaman_tahsin'] : '';
    $surat_tilawah = isset($_POST['surat_tilawah']) ? $_POST['surat_tilawah'] : '';
    $halaman_tilawah = isset($_POST['halaman_tilawah']) ? $_POST['halaman_tilawah'] : '';
    $berat_badan = isset($_POST['berat_badan']) ? $_POST['berat_badan'] : '';
    $tinggi_badan = isset($_POST['tinggi_badan']) ? $_POST['tinggi_badan'] : '';
    $fisik_keterangan = isset($_POST['fisik_keterangan']) ? $_POST['fisik_keterangan'] : '';
    $catatan_wali = isset($_POST['catatan_wali']) ? $_POST['catatan_wali'] : '';


    // Cek apakah data sudah ada untuk student_id yang sama
    $check_sql = "SELECT COUNT(*) as total FROM ekstrakurikuler WHERE student_id = '$student_id'";
    $check_result = $conn->query($check_sql);
    $row = $check_result->fetch_assoc();

    if ($row['total'] > 0) {
        // Update data jika sudah ada
        $update_sql = "UPDATE ekstrakurikuler 
        SET pramuka_predikat = '$pramuka_predikat', 
            pramuka_keterangan = '$pramuka_keterangan', 
            silat_predikat = '$silat_predikat', 
            silat_keterangan = '$silat_keterangan', 
            jurnalistik_predikat = '$jurnalistik_predikat', 
            jurnalistik_keterangan = '$jurnalistik_keterangan', 
            melukis_predikat = '$melukis_predikat', 
            melukis_keterangan = '$melukis_keterangan', 
            futsal_predikat = '$futsal_predikat', 
            futsal_keterangan = '$futsal_keterangan', 
            kir_predikat = '$kir_predikat', 
            kir_keterangan = '$kir_keterangan', 
            leader_community_predikat = '$leader_community_predikat', 
            leader_community_keterangan = '$leader_community_keterangan', 
            english_club_predikat = '$english_club_predikat', 
            english_club_keterangan = '$english_club_keterangan', 
            sakit = '$sakit', 
            ijin = '$ijin', 
            tanpa_kabar = '$tanpa_kabar', 
            juz = '$juz', 
            surat_tahfizh = '$surat_tahfizh', 
            jilid_tahsin = '$jilid_tahsin', 
            halaman_tahsin = '$halaman_tahsin', 
            surat_tilawah = '$surat_tilawah', 
            halaman_tilawah = '$halaman_tilawah', 
            berat_badan = '$berat_badan', 
            tinggi_badan = '$tinggi_badan', 
            fisik_keterangan = '$fisik_keterangan', 
            catatan_wali = '$catatan_wali'
        WHERE student_id = '$student_id'";

        if ($conn->query($update_sql) === TRUE) {
            $message = "Data ekstrakurikuler berhasil diperbarui!";
        } else {
            $error = "Error saat memperbarui data: " . $conn->error;
        }
    } else {
        // Insert data baru jika belum ada
        $insert_sql = "INSERT INTO ekstrakurikuler (student_id, sakit, ijin, tanpa_kabar, juz, surat_tahfizh, jilid_tahsin, halaman_tahsin, surat_tilawah, halaman_tilawah, berat_badan, tinggi_badan, fisik_keterangan, catatan_wali, english_club_keterangan, english_club_predikat, leader_community_keterangan, leader_community_predikat, kir_keterangan, kir_predikat, melukis_keterangan, melukis_predikat, pramuka_keterangan, pramuka_predikat, jurnalistik_keterangan, jurnalistik_predikat, futsal_keterangan, futsal_predikat,  silat_keterangan, silat_predikat)
                       VALUES ('$student_id', '$sakit', '$ijin', '$tanpa_kabar', '$juz', '$surat_tahfizh', '$jilid_tahsin', '$halaman_tahsin', '$surat_tilawah', '$halaman_tilawah', '$berat_badan', '$tinggi_badan', '$fisik_keterangan', '$catatan_wali', '$english_club_keterangan','$english_club_predikat', '$leader_community_predikat','$leader_community_keterangan', '$kir_keterangan', '$kir_predikat', '$futsal_keterangan','$futsal_predikat', '$pramuka_keterangan', '$pramuka_predikat', '$jurnalistik_keterangan', '$jurnalistik_predikat', '$silat_keterangan', '$silat_predikat',  '$melukis_keterangan', '$melukis_predikat')";

        if ($conn->query($insert_sql) === TRUE) {
            $message = "Data ekstrakurikuler berhasil disimpan!";
        } else {
            $error = "Error saat menyimpan data: " . $conn->error;
        }
    }
}

// Handle class and student filters
$selected_class = '';
$selected_student = '';
$students_result = null;
$ekskul_data = [];

if (isset($_POST['filter_class'])) {
    $selected_class = $_POST['selected_class'];

    // Ambil data siswa berdasarkan kelas yang dipilih
    $students_sql = "SELECT * FROM students WHERE student_class = '$selected_class'";
    $students_result = $conn->query($students_sql);
}

if (isset($_POST['filter_student'])) {
    $selected_class = $_POST['selected_class'];
    $selected_student = $_POST['student_id'];

    // Ambil data ekstrakurikuler berdasarkan siswa yang dipilih
    $ekskul_sql = "SELECT * FROM ekstrakurikuler WHERE student_id = '$selected_student'";
    $ekskul_result = $conn->query($ekskul_sql);

    if ($ekskul_result && $ekskul_result->num_rows > 0) {
        $ekskul_data = $ekskul_result->fetch_assoc();
    } else {
        // Inisialisasi variabel kosong jika data tidak ada
        $ekskul_data = [
            'pramuka_predikat' => '',
            'pramuka_keterangan' => '',
            'silat_predikat' => '',
            'silat_keterangan' => '',
            'jurnalistik_predikat' => '',
            'jurnalistik_keterangan' => '',
            'melukis_predikat' => '',
            'melukis_keterangan' => '',
            'futsal_predikat' => '',
            'futsal_keterangan' => '',
            'kir_predikat' => '',
            'kir_keterangan' => '',
            'leader_community_predikat' => '',
            'leader_community_keterangan' => '',
            'english_club_predikat' => '',
            'english_club_keterangan' => '',
            'sakit' => '',
            'ijin' => '',
            'tanpa_kabar' => '',
            'juz' => '',
            'surat_tahfizh' => '',
            'jilid_tahsin' => '',
            'halaman_tahsin' => '',
            'surat_tilawah' => '',
            'halaman_tilawah' => '',
            'berat_badan' => '',
            'tinggi_badan' => '',
            'fisik_keterangan' => '',
            'catatan_wali' => ''
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Ekstrakurikuler</title>
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
                <h1 class="h3 mb-2 text-gray-800">Input Ekstrakurikuler</h1>

                <!-- Tampilkan pesan sukses atau error -->
                <?php if ($message) { echo "<div class='alert alert-success'>$message</div>"; } ?>
                <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                <!-- Filter berdasarkan kelas -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Filter Siswa Berdasarkan Kelas</h6>
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
                            <button type="submit" name="filter_class" class="btn btn-primary">Filter Kelas</button>
                        </form>
                    </div>
                </div>

                <?php if ($students_result && $students_result->num_rows > 0): ?>
                    <!-- Filter berdasarkan siswa -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pilih Siswa</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <input type="hidden" name="selected_class" value="<?php echo $selected_class; ?>">
                                <div class="form-group">
                                    <label for="student_id">Pilih Siswa</label>
                                    <select name="student_id" class="form-control" required>
                                        <option value="">Pilih Siswa</option>
                                        <?php while ($student = $students_result->fetch_assoc()) { ?>
                                            <option value="<?php echo $student['id']; ?>" <?php if ($selected_student == $student['id']) echo 'selected'; ?>>
                                                <?php echo $student['student_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="submit" name="filter_student" class="btn btn-primary">Pilih Siswa</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Render form input absensi dan data ekstrakurikuler -->
                <?php if ($selected_student): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Input Data Ekstrakurikuler dan Absensi</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <input type="hidden" name="student_id" value="<?php echo $selected_student; ?>">

                                <!-- Kegiatan Ekstrakurikuler -->
                                <h5>Kegiatan Ekstrakurikuler</h5>
                                <!-- Tambahkan form data ekstrakurikuler di sini sesuai keperluan -->
                                <!-- Pramuka -->
                                <div class="form-group">
                                    <label for="pramuka_predikat">Pramuka - Predikat</label>
                                    <select name="pramuka_predikat" class="form-control">
                                        <option value="A" <?php echo isset($ekskul_data['pramuka_predikat']) && $ekskul_data['pramuka_predikat'] == 'A' ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?php echo isset($ekskul_data['pramuka_predikat']) && $ekskul_data['pramuka_predikat'] == 'B' ? 'selected' : ''; ?>>B</option>
                                        <option value="C" <?php echo isset($ekskul_data['pramuka_predikat']) && $ekskul_data['pramuka_predikat'] == 'C' ? 'selected' : ''; ?>>C</option>
                                        <option value="D" <?php echo isset($ekskul_data['pramuka_predikat']) && $ekskul_data['pramuka_predikat'] == 'D' ? 'selected' : ''; ?>>D</option>
                                        <option value="-" <?php echo isset($ekskul_data['pramuka_predikat']) && $ekskul_data['pramuka_predikat'] == '-' ? 'selected' : ''; ?>>-</option>
                                    </select>
                                    <label for="pramuka_keterangan">Keterangan Pramuka</label>
                                    <textarea name="pramuka_keterangan" class="form-control"><?php echo isset($ekskul_data['pramuka_keterangan']) ? $ekskul_data['pramuka_keterangan'] : ''; ?></textarea>
                                </div>

                                <!-- Silat -->
                                <div class="form-group">
                                    <label for="silat_predikat">Silat - Predikat</label>
                                    <select name="silat_predikat" class="form-control">
                                        <option value="A" <?php echo isset($ekskul_data['silat_predikat']) && $ekskul_data['silat_predikat'] == 'A' ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?php echo isset($ekskul_data['silat_predikat']) && $ekskul_data['silat_predikat'] == 'B' ? 'selected' : ''; ?>>B</option>
                                        <option value="C" <?php echo isset($ekskul_data['silat_predikat']) && $ekskul_data['silat_predikat'] == 'C' ? 'selected' : ''; ?>>C</option>
                                        <option value="D" <?php echo isset($ekskul_data['silat_predikat']) && $ekskul_data['silat_predikat'] == 'D' ? 'selected' : ''; ?>>D</option>
                                        <option value="-" <?php echo isset($ekskul_data['silat_predikat']) && $ekskul_data['silat_predikat'] == '-' ? 'selected' : ''; ?>>-</option>
                                    </select>
                                    <label for="silat_keterangan">Keterangan Silat</label>
                                    <textarea name="silat_keterangan" class="form-control"><?php echo isset($ekskul_data['silat_keterangan']) ? $ekskul_data['silat_keterangan'] : ''; ?></textarea>
                                </div>

                                <!-- Jurnalistik -->
                                <div class="form-group">
                                    <label for="jurnalistik_predikat">Jurnalistik - Predikat</label>
                                    <select name="jurnalistik_predikat" class="form-control">
                                        <option value="A" <?php echo isset($ekskul_data['jurnalistik_predikat']) && $ekskul_data['jurnalistik_predikat'] == 'A' ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?php echo isset($ekskul_data['jurnalistik_predikat']) && $ekskul_data['jurnalistik_predikat'] == 'B' ? 'selected' : ''; ?>>B</option>
                                        <option value="C" <?php echo isset($ekskul_data['jurnalistik_predikat']) && $ekskul_data['jurnalistik_predikat'] == 'C' ? 'selected' : ''; ?>>C</option>
                                        <option value="D" <?php echo isset($ekskul_data['jurnalistik_predikat']) && $ekskul_data['jurnalistik_predikat'] == 'D' ? 'selected' : ''; ?>>D</option>
                                        <option value="-" <?php echo isset($ekskul_data['jurnalistik_predikat']) && $ekskul_data['jurnalistik_predikat'] == '-' ? 'selected' : ''; ?>>-</option>
                                    </select>
                                    <label for="jurnalistik_keterangan">Keterangan Jurnalistik</label>
                                    <textarea name="jurnalistik_keterangan" class="form-control"><?php echo isset($ekskul_data['jurnalistik_keterangan']) ? $ekskul_data['jurnalistik_keterangan'] : ''; ?></textarea>
                                </div>

                                <!-- Melukis -->
                                <div class="form-group">
                                    <label for="melukis_predikat">Melukis - Predikat</label>
                                    <select name="melukis_predikat" class="form-control">
                                        <option value="A" <?php echo isset($ekskul_data['melukis_predikat']) && $ekskul_data['melukis_predikat'] == 'A' ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?php echo isset($ekskul_data['melukis_predikat']) && $ekskul_data['melukis_predikat'] == 'B' ? 'selected' : ''; ?>>B</option>
                                        <option value="C" <?php echo isset($ekskul_data['melukis_predikat']) && $ekskul_data['melukis_predikat'] == 'C' ? 'selected' : ''; ?>>C</option>
                                        <option value="D" <?php echo isset($ekskul_data['melukis_predikat']) && $ekskul_data['melukis_predikat'] == 'D' ? 'selected' : ''; ?>>D</option>
                                        <option value="-" <?php echo isset($ekskul_data['melukis_predikat']) && $ekskul_data['melukis_predikat'] == '-' ? 'selected' : ''; ?>>-</option>
                                    </select>
                                    <label for="melukis_keterangan">Keterangan Melukis</label>
                                    <textarea name="melukis_keterangan" class="form-control"><?php echo isset($ekskul_data['melukis_keterangan']) ? $ekskul_data['melukis_keterangan'] : ''; ?></textarea>
                                </div>

                                <!-- Futsal -->
                                <div class="form-group">
                                    <label for="futsal_predikat">Futsal - Predikat</label>
                                    <select name="futsal_predikat" class="form-control">
                                        <option value="A" <?php echo isset($ekskul_data['futsal_predikat']) && $ekskul_data['futsal_predikat'] == 'A' ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?php echo isset($ekskul_data['futsal_predikat']) && $ekskul_data['futsal_predikat'] == 'B' ? 'selected' : ''; ?>>B</option>
                                        <option value="C" <?php echo isset($ekskul_data['futsal_predikat']) && $ekskul_data['futsal_predikat'] == 'C' ? 'selected' : ''; ?>>C</option>
                                        <option value="D" <?php echo isset($ekskul_data['futsal_predikat']) && $ekskul_data['futsal_predikat'] == 'D' ? 'selected' : ''; ?>>D</option>
                                        <option value="-" <?php echo isset($ekskul_data['futsal_predikat']) && $ekskul_data['futsal_predikat'] == '-' ? 'selected' : ''; ?>>-</option>
                                    </select>
                                    <label for="futsal_keterangan">Keterangan Futsal</label>
                                    <textarea name="futsal_keterangan" class="form-control"><?php echo isset($ekskul_data['futsal_keterangan']) ? $ekskul_data['futsal_keterangan'] : ''; ?></textarea>
                                </div>

                                <!-- KIR -->
                                <div class="form-group">
                                    <label for="kir_predikat">KIR - Predikat</label>
                                    <select name="kir_predikat" class="form-control">
                                        <option value="A" <?php echo isset($ekskul_data['kir_predikat']) && $ekskul_data['kir_predikat'] == 'A' ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?php echo isset($ekskul_data['kir_predikat']) && $ekskul_data['kir_predikat'] == 'B' ? 'selected' : ''; ?>>B</option>
                                        <option value="C" <?php echo isset($ekskul_data['kir_predikat']) && $ekskul_data['kir_predikat'] == 'C' ? 'selected' : ''; ?>>C</option>
                                        <option value="D" <?php echo isset($ekskul_data['kir_predikat']) && $ekskul_data['kir_predikat'] == 'D' ? 'selected' : ''; ?>>D</option>
                                        <option value="-" <?php echo isset($ekskul_data['kir_predikat']) && $ekskul_data['kir_predikat'] == '-' ? 'selected' : ''; ?>>-</option>
                                    </select>
                                    <label for="kir_keterangan">Keterangan KIR</label>
                                    <textarea name="kir_keterangan" class="form-control"><?php echo isset($ekskul_data['kir_keterangan']) ? $ekskul_data['kir_keterangan'] : ''; ?></textarea>
                                </div>

                                <!-- Leader Community -->
                                <div class="form-group">
                                    <label for="leader_community_predikat">Leader Community - Predikat</label>
                                    <select name="leader_community_predikat" class="form-control">
                                        <option value="A" <?php echo isset($ekskul_data['leader_community_predikat']) && $ekskul_data['leader_community_predikat'] == 'A' ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?php echo isset($ekskul_data['leader_community_predikat']) && $ekskul_data['leader_community_predikat'] == 'B' ? 'selected' : ''; ?>>B</option>
                                        <option value="C" <?php echo isset($ekskul_data['leader_community_predikat']) && $ekskul_data['leader_community_predikat'] == 'C' ? 'selected' : ''; ?>>C</option>
                                        <option value="D" <?php echo isset($ekskul_data['leader_community_predikat']) && $ekskul_data['leader_community_predikat'] == 'D' ? 'selected' : ''; ?>>D</option>
                                        <option value="-" <?php echo isset($ekskul_data['leader_community_predikat']) && $ekskul_data['leader_community_predikat'] == '-' ? 'selected' : ''; ?>>-</option>
                                    </select>
                                    <label for="leader_community_keterangan">Keterangan Leader Community</label>
                                    <textarea name="leader_community_keterangan" class="form-control"><?php echo isset($ekskul_data['leader_community_keterangan']) ? $ekskul_data['leader_community_keterangan'] : ''; ?></textarea>
                                </div>

                                <!-- English Club -->
                                <div class="form-group">
                                    <label for="english_club_predikat">English Club - Predikat</label>
                                    <select name="english_club_predikat" class="form-control">
                                        <option value="A" <?php echo isset($ekskul_data['english_club_predikat']) && $ekskul_data['english_club_predikat'] == 'A' ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?php echo isset($ekskul_data['english_club_predikat']) && $ekskul_data['english_club_predikat'] == 'B' ? 'selected' : ''; ?>>B</option>
                                        <option value="C" <?php echo isset($ekskul_data['english_club_predikat']) && $ekskul_data['english_club_predikat'] == 'C' ? 'selected' : ''; ?>>C</option>
                                        <option value="D" <?php echo isset($ekskul_data['english_club_predikat']) && $ekskul_data['english_club_predikat'] == 'D' ? 'selected' : ''; ?>>D</option>
                                        <option value="-" <?php echo isset($ekskul_data['english_club_predikat']) && $ekskul_data['english_club_predikat'] == '-' ? 'selected' : ''; ?>>-</option>
                                    </select>
                                    <label for="english_club_keterangan">Keterangan English Club</label>
                                    <textarea name="english_club_keterangan" class="form-control"><?php echo isset($ekskul_data['english_club_keterangan']) ? $ekskul_data['english_club_keterangan'] : ''; ?></textarea>
                                </div>

                                <!-- Input Absensi -->
                                <h5>Absensi Ekstrakurikuler</h5>
                                <div class="form-group">
                                    <label for="sakit">Sakit</label>
                                    <input type="text" name="sakit" class="form-control" value="<?php echo isset($ekskul_data['sakit']) ? $ekskul_data['sakit'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ijin">Ijin</label>
                                    <input type="text" name="ijin" class="form-control" value="<?php echo isset($ekskul_data['ijin']) ? $ekskul_data['ijin'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="tanpa_kabar">Tanpa Kabar</label>
                                    <input type="text" name="tanpa_kabar" class="form-control" value="<?php echo isset($ekskul_data['tanpa_kabar']) ? $ekskul_data['tanpa_kabar'] : ''; ?>">
                                </div>

                                <!-- Capaian Tahfizh -->
                                <h5>Capaian Tahfizh</h5>
                                <div class="form-group">
                                    <label for="juz">Juz</label>
                                    <input type="text" name="juz" class="form-control" value="<?php echo isset($ekskul_data['juz']) ? $ekskul_data['juz'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="surat_tahfizh">Surat</label>
                                    <input type="text" name="surat_tahfizh" class="form-control" value="<?php echo isset($ekskul_data['surat_tahfizh']) ? $ekskul_data['surat_tahfizh'] : ''; ?>">
                                </div>

                                <!-- Capaian Tahsin -->
                                <h5>Capaian Tahsin</h5>
                                <div class="form-group">
                                    <label for="jilid_tahsin">Jilid / Surat</label>
                                    <input type="text" name="jilid_tahsin" class="form-control" value="<?php echo isset($ekskul_data['jilid_tahsin']) ? $ekskul_data['jilid_tahsin'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="halaman_tahsin">Halaman / Ayat</label>
                                    <input type="text" name="halaman_tahsin" class="form-control" value="<?php echo isset($ekskul_data['halaman_tahsin']) ? $ekskul_data['halaman_tahsin'] : ''; ?>">
                                </div>

                                <!-- Capaian Tilawah -->
                                <h5>Capaian Tilawah</h5>
                                <div class="form-group">
                                    <label for="surat_tilawah">Surat</label>
                                    <input type="text" name="surat_tilawah" class="form-control" value="<?php echo isset($ekskul_data['surat_tilawah']) ? $ekskul_data['surat_tilawah'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="halaman_tilawah">Halaman</label>
                                    <input type="text" name="halaman_tilawah" class="form-control" value="<?php echo isset($ekskul_data['halaman_tilawah']) ? $ekskul_data['halaman_tilawah'] : ''; ?>">
                                </div>

                                <!-- Pertumbuhan Fisik -->
                                <h5>Pertumbuhan Fisik</h5>
                                <div class="form-group">
                                    <label for="berat_badan">Berat Badan (Kg)</label>
                                    <input type="text" name="berat_badan" class="form-control" value="<?php echo isset($ekskul_data['berat_badan']) ? $ekskul_data['berat_badan'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="tinggi_badan">Tinggi Badan (Cm)</label>
                                    <input type="text" name="tinggi_badan" class="form-control" value="<?php echo isset($ekskul_data['tinggi_badan']) ? $ekskul_data['tinggi_badan'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="fisik_keterangan">Keterangan Pertumbuhan Fisik</label>
                                    <textarea name="fisik_keterangan" class="form-control"><?php echo isset($ekskul_data['fisik_keterangan']) ? $ekskul_data['fisik_keterangan'] : ''; ?></textarea>
                                </div>

                                <!-- Catatan Wali Kelas -->
                                <h5>Catatan Wali Kelas</h5>
                                <div class="form-group">
                                    <label for="catatan_wali">Catatan Wali Kelas</label>
                                    <textarea name="catatan_wali" class="form-control"><?php echo isset($ekskul_data['catatan_wali']) ? $ekskul_data['catatan_wali'] : ''; ?></textarea>
                                </div>
                                
                                <!-- Tombol Simpan -->
                                <button type="submit" name="save_ekstrakurikuler" class="btn btn-primary">Simpan Data</button>
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
