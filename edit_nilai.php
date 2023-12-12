<!DOCTYPE html>
    <?php
		include 'koneksi.php';

		$id_nilai ='';
		$npm = '';
		$nama_mahasiswa = '';
		$tugas = '';
		$uts = '';
		$uas = '';
        $tugas_akhir = '';

		if(isset($_GET['ubah'])){
			$id_nilai = $_GET['ubah'];
			// echo $id_nilai;

			$query = "SELECT * FROM nilai_mahasiswa WHERE id_nilai = '$id_nilai';";
			$sql = mysqli_query($conn, $query);

			$result = mysqli_fetch_assoc($sql);
			$npm = $result['npm'];
			$nama_mahasiswa = $result['nama_mahasiswa'];
			$tugas = $result['tugas'];
			$uts = $result['uts'];
			$uas = $result['uas'];
			$tugas_akhir = $result['tugas_akhir'];

			//var_dump($result);
			//die();
		}
	?>
<html lang="en">

<head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="favicon_io/site.webmanifest">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700&display=swap">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa; /* Light Gray Background */
            font-family: 'Raleway', sans-serif; /* Raleway font */
        }
    </style>

    <title>Edit Nilai Mahasiswa</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Ilmu UPNVJT - Edit Nilai</a>
        </div>
    </nav>
    <div class="container">

    <form method="POST" action="proses_edit_nilai.php">
        <input type="hidden" value="<?php echo $result['id_nilai']; ?>" name="id_nilai">

        <div class="mb-3 row">
            <label for="npm" class="col-sm-2 col-form-label">NPM</label>
            <div class="col-sm-10">
                <input required type="text" name="npm" class="form-control" id="npm" value="<?php echo $result['npm']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nama_mahasiswa" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input required type="text" name="nama_mahasiswa" class="form-control" id="nama_mahasiswa" value="<?php echo $result['nama_mahasiswa']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="tugas" class="col-sm-2 col-form-label">Nilai Tugas</label>
            <div class="col-sm-10">
                <input required type="text" name="tugas" class="form-control" id="tugas" value="<?php echo $result['tugas']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="uts" class="col-sm-2 col-form-label">Nilai UTS</label>
            <div class="col-sm-10">
                <input required type="text" name="uts" class="form-control" id="uts" value="<?php echo $result['uts']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="uas" class="col-sm-2 col-form-label">Nilai UAS</label>
            <div class="col-sm-10">
                <input required type="text" name="uas" class="form-control" id="uas" value="<?php echo $result['uas']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="tugas_akhir" class="col-sm-2 col-form-label">Nilai Praktikum</label>
            <div class="col-sm-10">
                <input required type="text" name="tugas_akhir" class="form-control" id="tugas_akhir" value="<?php echo $result['tugas_akhir']; ?>">
            </div>
        </div>

            <!-- Add other input fields for editing grades -->

            <div class="mb-3 row mt-4" style="text-align: right;">
                <div class="col">
                    <button type="submit" name="aksi" value="edit" class="btn btn-success">
                        Simpan Perubahan
                    </button>
                    <a href="nilai_mahasiswa.php" type="button" class="btn btn-danger">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
