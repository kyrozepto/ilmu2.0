<?php
	include 'koneksi.php';

	session_start();


	$query = "SELECT * FROM mahasiswa;";
	$sql = mysqli_query($conn, $query);
	$no = 0;
	//var_dump($result);
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