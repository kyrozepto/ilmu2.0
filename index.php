<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
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
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilmu UPNVJT</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="datatables/datatables.css">
    <!-- Custom CSS -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700&display=swap">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa; /* Light Gray Background */
            font-family: 'Raleway', sans-serif; /* Raleway font */
        }

        .navbar {
            background-color: #28a745; /* Green Navbar */
            color: #ffffff; /* White Text */
        }

        h1,
        h3 {
            color: #28a745; /* Green Headings */
        }

        blockquote {
            border-left: 5px solid #28a745; /* Green Blockquote */
        }

        .btn-outline-success {
            color: #28a745; /* Green Button Text */
            border-color: #28a745; /* Green Button Border */
        }

        .btn-outline-primary {
            color: #007bff; /* Blue Button Text */
            border-color: #007bff; /* Blue Button Border */
        }

        .btn-success {
            background-color: #28a745; /* Green Button Background */
            border-color: #28a745; /* Green Button Border */
        }

        .btn-danger {
            background-color: #dc3545; /* Red Button Background */
            border-color: #dc3545; /* Red Button Border */
        }

		.btn-outline-primary[data-filter-active="true"] {
			color: #fff; /* White Text */
			background-color: #007bff; /* Blue Background */
			border-color: #007bff; /* Blue Border */
		}

        .alert-success {
            background-color: #d4edda; /* Light Green Alert Background */
            border-color: #c3e6cb; /* Green Alert Border */
            color: #155724; /* Dark Green Alert Text */
        }

        .table {
            background-color: #ffffff; /* White Table Background */
        }

        th,
        td {
            border-color: #dee2e6; /* Light Gray Table Borders */
        }
    </style>
    <title>Ilmu UPNVJT</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Ilmu UPNVJT</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-4 text-center"><strong>DASHBOARD</strong></h1>
        <figure>
            <blockquote class="blockquote text-center">
                <p>Data Mahasiswa Aktif UPNVJT 2023</p>
            </blockquote>
        </figure>
        <div class="d-flex justify-content-end mb-3"> <!-- Use Bootstrap's flex utilities to align to the right -->
			<a href="kelola.php" type="button" class="btn btn-outline-success">
				Tambah Data
			</a>
			<button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#filterModal"
				<?php echo (!empty($npmFilter) || !empty($namaFilter) || !empty($genderFilter)) ? 'data-filter-active="true"' : ''; ?>>
				Filter
			</button>
		</div>

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
        if (isset($_SESSION['eksekusi'])) :
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
                        <th><center>Edit</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($result = mysqli_fetch_assoc($sql)) {
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
                                        <i class="fas fa-edit"></i> 
                                    </a>
                                    <a href="proses.php?hapus=<?php echo $result['id_mahasiswa']; ?>" type="button" class="btn btn-danger" onClick="return confirm('Apakah anda ingin menghapus data yang dipilih?')">
                                        <i class="fas fa-trash"></i> 
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

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="datatables/datatables.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#dt').DataTable();
        });
    </script>
</body>

</html>
