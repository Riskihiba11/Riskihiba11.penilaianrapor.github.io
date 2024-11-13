function kunciNilai(id, teacherId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin mengunci nilai ini? Nilai yang sudah dikunci tidak dapat diubah kembali.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kunci',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'app/Controllers/GradeController.php',
                type: 'POST',
                data: {
                    action: 'kunci',
                    id: id,
                    teacher_id: teacherId
                },
                success: function(response) {
                    let hasil = JSON.parse(response);
                    Swal.fire({
                        title: hasil.status == 'sukses' ? 'Berhasil' : 'Gagal',
                        text: hasil.pesan,
                        icon: hasil.status == 'sukses' ? 'success' : 'error'
                    }).then(() => {
                        if(hasil.status == 'sukses') {
                            location.reload();
                        }
                    });
                }
            });
        }
    });
}
