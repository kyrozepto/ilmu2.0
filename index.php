<?php
    include 'koneksi.php';
    session_start();

    // Initialize filter conditions
    $npmFilter = isset($_GET['npm']) ? $_GET['npm'] : '';
    $namaFilter = isset($_GET['nama']) ? $_GET['nama'] : '';
    $genderFilter = isset($_GET['gender']) ? $_GET['gender'] : '';

    // Build the SQL query with filter conditions if filters are present
    if (!empty($npmFilter) || !empty($namaFilter) || !empty($genderFilter)) {
        $query = "SELECT * FROM mahasiswa WHERE 1";

        if (!empty($npmFilter)) {
            $query .= " AND npm = '$npmFilter'";
        }

        if (!empty($namaFilter)) {
            $query .= " AND nama_mahasiswa LIKE '%$namaFilter%'";
        }

        if (!empty($genderFilter)) {
            $query .= " AND gender = '$genderFilter'";
        }

        $query .= ";";
    } else {
        // If no filters, fetch all data
        $query = "SELECT * FROM mahasiswa;";
    }

    $sql = mysqli_query($conn, $query);
    $no = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!--Bottstrap-->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"> </script>

	<link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">

	<link rel="stylesheet" href="datatables/datatables.css">
	<script type="text/javascript" src="datatables/datatables.js"></script>

	<title>Ilmu UPNVJT</title>
</head>

<script type="text/javascript">
	$(document).ready(function(){
		$('#dt').DataTable();

	});
</script>
<body>
	<nav class="navbar bg-body-tertiary">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#">
	      Ilmu UPNVJT
	    </a>
	  </div>
	</nav>

	<div class="container">
		<h1 class="mt-4">
			<center><strong>
				DASBOARD
			</strong>
			</center>
		</h1>
		<figure>
		  <blockquote class="blockquote">
		    <p>Mahasiswa</p>
		  </blockquote>
		  <figcaption class="blockquote-footer">
		    Data Mahasiswa Aktif UPNVJT <cite title="Source Title">2023</cite>
		  </figcaption>
		</figure>
		<a href="kelola.php" type="button" class="btn btn-outline-success mb-3">
			Tambah Data
		</a>
		<button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#filterModal">
    		Filter Data
		</button>

		<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="filterModalLabel">Filter Data Mahasiswa</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
				<form action="index.php" method="get">
					<div class="mb-3">
						<label for="npmFilter" class="form-label">NPM</label>
						<input type="text" class="form-control" id="npmFilter" name="npm">
					</div>
					<div class="mb-3">
						<label for="namaFilter" class="form-label">Nama Mahasiswa</label>
						<input type="text" class="form-control" id="namaFilter" name="nama">
					</div>
					<div class="mb-3">
						<label for="genderFilter" class="form-label">Gender</label>
						<select class="form-select" id="genderFilter" name="gender">
						<option value="">Semua</option>
						<option value="Pria">Pria</option>
						<option value="Wanita">Wanita</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Filter</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
				</form>

				</div>
				</div>
			</div>
			</div>

		<?php
			if(isset($_SESSION['eksekusi'])):
		?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
	  			<strong>
	  				<?php
	  				echo $_SESSION['eksekusi'];
					?>
				</strong>
	  			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php
			session_destroy();
			endif;
		?>
		<div class="table-responsive">
		  	<table id="dt" class="table align-middle cell-border hover">
		    	<thead>
		      		<tr>
		       			<th><center>No.</center></th>
		       			<th><center>NPM</center></th>
		       			<th><center>Foto Profil</center></th>
		       			<th>Nama</th>
		       			<th>Gender</th>
		       			<th><center>Tanggal Lahir</center></th>
		       			<th>Alamat</th>
		       			<th><center>Opsi</center></th>
		      		</tr>
		   		</thead>
	  		  	<tbody>
	  		  	<?php
	  		  		while($result = mysqli_fetch_assoc($sql))
	  		  	{
	  		  	?>
	    		  	<tr>
	     			   	<td>
	     			   		<center>
	     			   		<?php echo ++$no; ?>.
	     			   		</center>
	     			   	</td>
	     			   	<td>
	     			   		<center>
	     			   		<?php echo $result['npm']; ?>
	     			   		</center>
	     			   	</td>
	     			   	<td>
	     			   		<center>
	     			   		<img src="img/<?php echo $result['foto_mahasiswa']; ?>" style="width: 50px">
	     			   		</center>
	     			   	</td>
	     			   	<td>
	     			   		<?php echo $result['nama_mahasiswa']; ?>
	     			   	</td>
	     			   	<td>
	     			   		<?php echo $result['gender']; ?>
	     			   	</td>
	     			   	<td>
	     			   		<center>
	     			   		<?php echo $result['tanggal_lahir']; ?>
	     			   		</center>
	     			   	</td>
	     			   	<td>
	     			   		<?php echo $result['alamat']; ?>
	     			   	</td>
	     			   	<td>
	     			   		<center>
	     			   		<a href="kelola.php?ubah=<?php echo $result['id_mahasiswa']; ?>" type="button" class="btn btn-success">
	     			   			Ubah
	     			   		</a>	     			   		
	     			   		<a href="proses.php?hapus=<?php echo $result['id_mahasiswa']; ?>" type="button" class="btn btn-danger" onClick="return confirm('Apakah anda ingin menghapus data yang dipilih?')">
	     			   			Hapus
	     			   		</a>
	     			   		</center>
	     			   	</td>
	    		  	</tr>
	    		<?php
	    		 }
	    		?>
		     	</tbody>
		   	</table>
		</div>
	</div>
	<div class="mb-10"></div>
</body>
</html>
