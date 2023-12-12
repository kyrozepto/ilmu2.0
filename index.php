    <?php
    include 'koneksi.php';
    session_start();
	
    // masih problem
    // if (!isset($_SESSION['first_visit'])) {
    //     $_SESSION['first_visit'] = true;
    //     header("Location: landing.php");
    //     exit();
    // }

    function getFilterOptions() {
        $queryKota = "SELECT nama_kota FROM filter_kota";
        $resultKota = mysqli_query($GLOBALS['conn'], $queryKota);
    
        $queryAngkatan = "SELECT DISTINCT SUBSTRING(npm, 1, 2) AS angkatan FROM mahasiswa";
        $resultAngkatan = mysqli_query($GLOBALS['conn'], $queryAngkatan);
    
        $options = [];
    
        while ($rowKota = mysqli_fetch_assoc($resultKota)) {
            $options['kota'][] = $rowKota['nama_kota'];
        }
    
        while ($rowAngkatan = mysqli_fetch_assoc($resultAngkatan)) {
            $options['angkatan'][] = $rowAngkatan['angkatan'];
        }
    
        return $options;
    }
    
    // Initialize filter conditions
    $npmFilter = isset($_GET['npm']) ? $_GET['npm'] : '';
    $namaFilter = isset($_GET['nama']) ? $_GET['nama'] : '';
    $genderFilter = isset($_GET['gender']) ? $_GET['gender'] : '';
    $kotaFilter = isset($_GET['alamat'])? $_GET['alamat'] : '';
    $jurusanFilter = isset($_GET['jurusan']) ? $_GET['jurusan'] : '';
    $angkatanFilter = isset($_GET['angkatan']) ? $_GET['angkatan'] : '';


    // Build the SQL query with filter conditions if filters are present
    if (!empty($npmFilter) || !empty($namaFilter) || !empty($genderFilter) || !empty($kotaFilter) || !empty($jurusanFilter) || !empty($angkatanFilter)) {
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

        if (!empty($kotaFilter)) {
            $query .= " AND SUBSTRING_INDEX(alamat, ' ', -1) = '$kotaFilter'";
        }
        
        if (!empty($jurusanFilter)) {
            $query .= " AND jurusan = '$jurusanFilter'";
        }

        if (!empty($angkatanFilter)) {
            $query .= " AND SUBSTRING(npm, 1, 2) = '$angkatanFilter'";
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
        <title>Informasi Mahasiswa - Database Ilmu</title>
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
                border-left: 3px solid #28a745; /* Green Blockquote */
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
        
            div.dataTables_wrapper div.dataTables_filter input {
                width: 215px; /* Sesuaikan lebar sesuai kebutuhan Anda */
                margin-bottom: 0px; /* Tambahkan spasi bawah jika diinginkan */
            }
        </style>
        <title>Ilmu UPNVJT</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container d-flex justify-content-between"> <!-- Align items on the right -->
                <a class="navbar-brand" href="#"><strong>Database Ilmu</strong> - Infomasi Mahasiswa</a>
                <a href="landing.php" class="btn btn-outline-light">
                    Keluar <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </nav>

        <div class="container">
            <h1 class="mt-4 text-center"><strong>Informasi Mahasiswa</strong></h1>
            <figure>
                <blockquote class="blockquote text-center">
                    <p>Data Mahasiswa Aktif 2023</p>
                </blockquote>
            </figure>
            <div class="d-flex justify-content-end mb-2"> <!-- Use Bootstrap's flex utilities to align to the right -->
                <a href="nilai_mahasiswa.php" type="button" class="btn btn-outline-primary">
                    Lihat Nilai Mahasiswa <i class="fas fa-arrow-right"></i>
                </a>
            </div>
                
            <div class="d-flex justify-content-end mb-2"> <!-- Use Bootstrap's flex utilities to align to the right -->
                <a href="kelola.php" type="button" class="btn btn-outline-success ms-2">
                    Tambah Data
                </a>
                <button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#filterModal"
                    <?php echo (!empty($npmFilter) || !empty($namaFilter) || !empty($genderFilter) || !empty($kotaFilter) || !empty($jurusanFilter) || !empty($angkatanFilter)) ? 'data-filter-active="true"' : ''; ?>>
                    Filter <i class="fas fa-filter"></i>
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
                                    <label for="angkatanFilter" class="form-label">Tahun Penerimaan</label>
                                    <select class="form-select" id="angkatanFilter" name="angkatan">
                                        <option value="">Semua</option>
                                        <?php
                                        $angkatanOptions = getFilterOptions()['angkatan'];
                                        foreach ($angkatanOptions as $option) {
                                            echo "<option value=\"$option\"";
                                            echo ($angkatanFilter === $option) ? 'selected' : '';
                                            echo ">$option</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jurusanFilter" class="form-label">Jurusan</label>
                                    <select class="form-select" id="jurusanFilter" name="jurusan">
                                        <option value="">Semua</option>
                                        <option value="081">Informatika</option>
                                        <option value="082">Sistem Informasi</option>
                                        <option value="083">Sains Data</option>
                                        <option value="084">Bisnis Digital</option>
                                        <!-- Add more options as needed for other faculties and majors -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="genderFilter" class="form-label">Gender</label>
                                    <select class="form-select" id="genderFilter" name="gender">
                                        <option value="">Semua</option>
                                        <option value="Pria">Pria</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="kotaFilter" class="form-label">Asal Kota/Kabupaten</label>
                                    <select class="form-select" id="kotaFilter" name="alamat">
                                        <option value="">Semua</option>
                                        <?php
                                        $filterOptions = getFilterOptions();
                                        foreach ($filterOptions['kota'] as $option) {
                                            $selected = ($kotaFilter === $option) ? 'selected' : '';
                                            echo "<option value=\"$option\" $selected>$option</option>";
                                        }
                                        
                                        ?>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- Filter and Cancel Buttons -->
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <button type="button" class="btn btn-secondary ms-1" data-bs-dismiss="modal">Batal</button>
                                    </div>

                                <!-- Reset Filter Button (moved to the right) -->
                                <button type="button" class="btn btn-outline-secondary" onclick="resetFilter()">Reset Filter</button>
                                </div>
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
                                            <i class="fa-solid fa-file-pen"></i>
                                        </a>
                                        <a href="proses.php?hapus=<?php echo $result['id_mahasiswa']; ?>" type="button" class="btn btn-danger" onClick="return confirm('Apakah anda ingin menghapus data yang dipilih?')">
                                            <i class="fa-solid fa-user-minus"></i>
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
        <div class="mb-0">

        </div>

        <script>
        function resetFilter() {
            // Reset input values to empty
            document.getElementById('jurusanFilter').value = '';
            document.getElementById('genderFilter').value = '';
            document.getElementById('kotaFilter').value = '';
            document.getElementById('angkatanFilter').value = '';
        }
        </script>
        
        <!-- Bootstrap JS -->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- DataTables JS -->
        <script type="text/javascript" src="datatables/datatables.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dt').DataTable({
                    "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "language": {
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ mahasiswa",
                        "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                        "search": "Cari NPM/Nama:",
                        // Add more language options as needed
                    },
                    "columnDefs": [
                        { "searchable": false, "targets": [0, 4, 5, 6, 7] } // Menonaktifkan pencarian pada kolom 1, 5, 6, 7, dan 8
                    ]
                });
            });
        </script>
    </body>

    </html>
