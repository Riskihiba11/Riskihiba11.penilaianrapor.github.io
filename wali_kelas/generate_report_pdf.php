<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sekolah";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data input
$siswa_id = $_GET['student_id'];
$tahun_ajaran = $_POST['tahun_ajaran'];
$semester = $_GET['semester'];

// Dapatkan tanggal hari ini
$tanggal_hari_ini = date('d');
$bulan_hari_ini = date('F');
$tahun_hari_ini = date('Y');

// Query untuk mengambil data siswa
$sql = "SELECT * FROM students WHERE id = '$siswa_id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $siswa = $result->fetch_assoc();

    // Mendapatkan nama file foto dari database
    $photoFileName = $siswa['photo'];
    $photoPath = "../uploads/" . $photoFileName; // Lokasi file di folder uploads

    // Cek apakah file foto tersebut ada di folder uploads
    if (file_exists($photoPath)) {
        echo "Gambar ditemukan: $photoPath<br>";
    } else {
        echo "Gambar tidak ditemukan di folder uploads: $photoPath<br>";
        $photoPath = null;
    }

    // Ambil data capaian hasil belajar (Sikap Spiritual dan Sosial)
    $sql_capaian = "SELECT * FROM capaian_hasil WHERE student_id = '$siswa_id'";
    $result_capaian = $conn->query($sql_capaian);
    $capaian = $result_capaian->fetch_assoc();

    // Ambil data grades dengan join subjects
    $sql_grades = "
        SELECT g.knowledge_grade, g.knowledge_predicate, g.knowledge_description, 
               g.skill_grade, g.skill_predicate, g.skill_description, 
               s.subject_name
        FROM grades g
        JOIN subjects s ON g.subject_id = s.id
        WHERE g.student_id = '$siswa_id' AND g.semester = '$semester'
    ";
    $result_grades = $conn->query($sql_grades);

    // Ambil data ekstrakurikuler
    $sql_ekstrakurikuler = "SELECT * FROM ekstrakurikuler WHERE student_id = '$siswa_id'";
    $result_ekstrakurikuler = $conn->query($sql_ekstrakurikuler);
    $ekstrakurikuler = $result_ekstrakurikuler->fetch_assoc();

    // Membuka template Word
    $templatePath = '../template.docx';
    if (!file_exists($templatePath)) {
        die("Template file tidak ditemukan!");
    }
    
    $templateProcessor = new TemplateProcessor($templatePath);

    // Mengisi data siswa ke template
    $templateProcessor->setValue('student_name', $siswa['student_name']);
    $templateProcessor->setValue('nis', $siswa['nis']);
    $templateProcessor->setValue('place_of_birth', $siswa['place_of_birth']);
    $templateProcessor->setValue('date_of_birth', $siswa['date_of_birth']);
    $templateProcessor->setValue('gender', $siswa['gender']);
    $templateProcessor->setValue('religion', $siswa['religion']);
    $templateProcessor->setValue('previous_education', $siswa['previous_education']);
    $templateProcessor->setValue('student_address', $siswa['student_address']);
    $templateProcessor->setValue('parent_address', $siswa['parent_address']);
    $templateProcessor->setValue('father_name', $siswa['father_name']);
    $templateProcessor->setValue('father_job', $siswa['father_job']);
    $templateProcessor->setValue('mother_name', $siswa['mother_name']);
    $templateProcessor->setValue('mother_job', $siswa['mother_job']);
    $templateProcessor->setValue('guardian_name', $siswa['guardian_name']);
    $templateProcessor->setValue('guardian_job', $siswa['guardian_job']);
    $templateProcessor->setValue('guardian_address', $siswa['guardian_address']);
    $templateProcessor->setValue('student_class', $siswa['student_class']);

    // Memasukkan foto ke dalam template Word jika tersedia
    if ($photoPath && file_exists($photoPath)) {
        $templateProcessor->setImageValue('photo', array('path' => $photoPath, 'width' => 100, 'height' => 150, 'ratio' => true));
        echo "Gambar berhasil dimasukkan ke dalam template Word.<br>";
    } else {
        $templateProcessor->setValue('photo', 'Foto tidak tersedia');
        echo "Foto tidak tersedia atau gambar tidak valid.<br>";
    }

    // Mengisi nilai Sikap Spiritual dan Sosial
    $templateProcessor->setValue('spiritual_predicate', $capaian['predikat_spiritual']);
    $templateProcessor->setValue('spiritual_description', $capaian['deskripsi_spiritual']);
    $templateProcessor->setValue('social_predicate', $capaian['predikat_sosial']);
    $templateProcessor->setValue('social_description', $capaian['deskripsi_sosial']);

    // Mengisi data nilai pengetahuan dan keterampilan
    if ($result_grades->num_rows > 0) {
        $count = 1;
        while ($row = $result_grades->fetch_assoc()) {
            $templateProcessor->setValue('subject_name#'.$count, $row['subject_name']);
            $templateProcessor->setValue('knowledge_grade#'.$count, $row['knowledge_grade']);
            $templateProcessor->setValue('knowledge_predicate#'.$count, $row['knowledge_predicate']);
            $templateProcessor->setValue('knowledge_description#'.$count, $row['knowledge_description']);
            $templateProcessor->setValue('skill_grade#'.$count, $row['skill_grade']);
            $templateProcessor->setValue('skill_predicate#'.$count, $row['skill_predicate']);
            $templateProcessor->setValue('skill_description#'.$count, $row['skill_description']);
            $count++;
        }
    }

    // Set nilai ekstrakurikuler
    $templateProcessor->setValue('pramuka_predikat', $ekstrakurikuler['pramuka_predikat']);
    $templateProcessor->setValue('pramuka_keterangan', $ekstrakurikuler['pramuka_keterangan']);
    $templateProcessor->setValue('silat_predikat', $ekstrakurikuler['silat_predikat']);
    $templateProcessor->setValue('silat_keterangan', $ekstrakurikuler['silat_keterangan']);
    $templateProcessor->setValue('jurnalistik_predikat', $ekstrakurikuler['jurnalistik_predikat']);
    $templateProcessor->setValue('jurnalistik_keterangan', $ekstrakurikuler['jurnalistik_keterangan']);
    $templateProcessor->setValue('melukis_predikat', $ekstrakurikuler['melukis_predikat']);
    $templateProcessor->setValue('melukis_keterangan', $ekstrakurikuler['melukis_keterangan']);
    $templateProcessor->setValue('futsal_predikat', $ekstrakurikuler['futsal_predikat']);
    $templateProcessor->setValue('futsal_keterangan', $ekstrakurikuler['futsal_keterangan']);
    $templateProcessor->setValue('kir_predikat', $ekstrakurikuler['kir_predikat']);
    $templateProcessor->setValue('kir_keterangan', $ekstrakurikuler['kir_keterangan']);
    $templateProcessor->setValue('leader_community_predikat', $ekstrakurikuler['leader_community_predikat']);
    $templateProcessor->setValue('leader_community_keterangan', $ekstrakurikuler['leader_community_keterangan']);
    $templateProcessor->setValue('english_club_predikat', $ekstrakurikuler['english_club_predikat']);
    $templateProcessor->setValue('english_club_keterangan', $ekstrakurikuler['english_club_keterangan']);
    $templateProcessor->setValue('sakit', $ekstrakurikuler['sakit']);
    $templateProcessor->setValue('ijin', $ekstrakurikuler['ijin']);
    $templateProcessor->setValue('tanpa_kabar', $ekstrakurikuler['tanpa_kabar']);
    $templateProcessor->setValue('juz', $ekstrakurikuler['juz']);
    $templateProcessor->setValue('surat_tahfizh', $ekstrakurikuler['surat_tahfizh']);
    $templateProcessor->setValue('jilid_tahsin', $ekstrakurikuler['jilid_tahsin']);
    $templateProcessor->setValue('halaman_tahsin', $ekstrakurikuler['halaman_tahsin']);
    $templateProcessor->setValue('surat_tilawah', $ekstrakurikuler['surat_tilawah']);
    $templateProcessor->setValue('halaman_tilawah', $ekstrakurikuler['halaman_tilawah']);
    $templateProcessor->setValue('berat_badan', $ekstrakurikuler['berat_badan']);
    $templateProcessor->setValue('tinggi_badan', $ekstrakurikuler['tinggi_badan']);
    $templateProcessor->setValue('fisik_keterangan', $ekstrakurikuler['fisik_keterangan']);
    $templateProcessor->setValue('catatan_wali', $ekstrakurikuler['catatan_wali']);

    // Set tahun ajaran, semester, dan tanggal cetak
    $templateProcessor->setValue('tahun_ajaran', $tahun_ajaran);
    $templateProcessor->setValue('semester', $semester);
    $templateProcessor->setValue('tanggal_hari_ini', $tanggal_hari_ini);
    $templateProcessor->setValue('bulan_hari_ini', $bulan_hari_ini);
    $templateProcessor->setValue('tahun_hari_ini', $tahun_hari_ini);

    // Nama file untuk disimpan dan diunduh
    $fileName = "raport_{$siswa['student_name']}_{$siswa['student_class']}.docx";
    $templateProcessor->saveAs($fileName);

    // Header untuk unduhan
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileName));
    readfile($fileName);

    // Menghapus file sementara
    unlink($fileName);
    exit;
} else {
    echo "Gagal membuat raport!";
}
