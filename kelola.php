<!DOCTYPE html>

	<?php
		include 'koneksi.php';

		$id_mahasiswa ='';
		$npm = '';
		$nama_mahasiswa = '';
		$gender = '';
		$tanggal_lahir = '';
		$alamat = '';


		if(isset($_GET['ubah'])){
			$id_mahasiswa = $_GET['ubah'];
			echo $id_mahasiswa;

			$query = "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa';";
			$sql = mysqli_query($conn, $query);

			$result = mysqli_fetch_assoc($sql);
			$npm = $result['npm'];
			$nama_mahasiswa = $result['nama_mahasiswa'];
			$gender = $result['gender'];
			$tanggal_lahir = $result['tanggal_lahir'];
			$alamat = $result['alamat'];

			//var_dump($result);
			//die();
		}
	?>

<html>
<head>
	<meta charset="utf-8">
	<!--Bottstrap-->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"> </script>

	<link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">

	<title>Ilmu UPNVJT</title>
</head>
<body>
	<nav class="navbar navbar-light bg-light mb-5">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#">
	      Ilmu UPNVJT
	    </a>
	  </div>
	</nav>
		<div class="container">
			<form method="POST" action="proses.php" enctype="multipart/form-data">
				<input type="hidden" value="<?php echo $id_mahasiswa; ?>" name="id_mahasiswa">
				<div class="mb-3 row">
	    		<label for="npm" class="col-sm-2 col-form-label">
	    			NPM
	    		</label>
	    		<div class="col-sm-10">
	      			<input required type="text" name="npm" class="form-control" id="npm" placeholder= ' Contoh: 22081010180' value="<?php echo $npm; ?>">
	    		</div>
	  		</div>
	 		<div class="mb-3 row">
	    		<label for="nama_mahasiswa" class="col-sm-2 col-form-label">
	    			Nama Mahasiswa
	    		</label>
	    		<div class="col-sm-10">
	      			<input required type="text" name="nama_mahasiswa" class="form-control" placeholder= ' Contoh: Ardiansyah' value="<?php echo $nama_mahasiswa; ?>">
	    		</div>
	  		</div>
	  		<div class="mb-3 row">
	    		<label for="gender" class="col-sm-2 col-form-label">
	    			Jenis Kelamin
	    		</label>
	    		<div class="col-sm-10">
					<select required id="gender" name="gender" class="form-select">
					    <option <?php if($gender == 'Pria'){ echo "selected"; } ?> value="Pria">Pria</option>
					    <option <?php if($gender == 'Wanita'){ echo "selected"; } ?> value="Wanita">Wanita</option>
					</select>
	    		</div>
	    	</div>
	  		<div class="mb-3 row">
	    		<label for="tanggal_lahir" class="col-sm-2 col-form-label">
	    			Tanggal Lahir
	    		</label>
	    		<div class="col-sm-10">
	      			<input required type="text" name="tanggal_lahir" class="form-control" placeholder= 'Contoh: 17-01-2002' value="<?php echo $tanggal_lahir; ?>">
	    		</div>
	  		</div>
			<div class="mb-2 row">
	    		<label for="foto_mahasiswa" class="col-sm-2 col-form-label">
	    			Foto Mahasiswa
	    		</label>
	    		<div class="col-sm-10">
	      			<input <?php if(!isset($_GET['ubah'])){echo "required";} ?> class="form-control" type="file" name="foto_mahasiswa" id="foto_mahasiswa" accept="image/*">
	    		</div>
	    	</div>

			<div class="mb-3 row">
			  	<label for="alamat" class="col-sm-2 col-form-label">
			  	Alamat Lengkap
				</label>
			  	<textarea required class="form-control" id="alamat" name="alamat" rows="3"><?php echo $alamat; ?></textarea>
			</div>

			<div class="mb-3 row mt-4" style="text-align: right;">
				<div class="col">
					<?php
						if(isset($_GET['ubah'])){
					?>
					<button type="submit" name="aksi" value="edit" class="btn btn-success">
						Simpan Perubahan
					</button>
					<?php
						} else {
					?>
					<button type="submit" name="aksi" value="add" class="btn btn-success">
						Tambah Data
					</button>
					<?php
					}
				?>
				<a href="index.php" type="button" class="btn btn-danger">
					Batal
				</a>
			</div>
		</form>
  	</div>
</body>
</html>