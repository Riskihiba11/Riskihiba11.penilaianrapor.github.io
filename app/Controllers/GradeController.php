public function kunciNilai() {
    $id = $_POST['id'];
    $teacher_id = $_POST['teacher_id'];

    $query = "UPDATE grades SET 
             status_kunci = 1,
             dikunci_oleh = '$teacher_id',
             waktu_dikunci = NOW()
             WHERE id = '$id'";
             
    $result = mysqli_query($this->koneksi, $query);
    
    echo json_encode([
        'status' => $result ? 'sukses' : 'gagal',
        'pesan' => $result ? 'Nilai berhasil dikunci' : 'Gagal mengunci nilai'
    ]);
}
