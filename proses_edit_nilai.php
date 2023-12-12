<?php
    include 'koneksi.php';
    include 'fungsi.php';
    session_start();

    if ($_POST['aksi'] == "edit") {

        $berhasil = ubah_nilai($_POST);

        if ($berhasil) {
            $_SESSION['eksekusi'] = "Nilai Berhasil Diperbarui";
            header("location: nilai_mahasiswa.php");
        } else {
            echo $berhasil;
        }
    }
?>
