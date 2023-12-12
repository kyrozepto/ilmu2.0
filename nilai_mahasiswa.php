<?php
include 'koneksi.php';
session_start();

$tugasFilter = isset($_GET['tugas']) ? $_GET['tugas'] : '';
$utsFilter = isset($_GET['uts']) ? $_GET['uts'] : '';
$uasFilter = isset($_GET['uas']) ? $_GET['uas'] : '';
$tugasAkhirFilter = isset($_GET['tugas_akhir']) ? $_GET['tugas_akhir'] : '';
$ipkFilter = isset($_GET['ipk']) ? $_GET['ipk'] : '';
$predikatFilter = isset($_GET['predikat']) ? $_GET['predikat'] : '';
$aboveAverageFilter = isset($_GET['above_average']) ? $_GET['above_average'] : '';
$belowAverageFilter = isset($_GET['below_average']) ? $_GET['below_average'] : '';

// Build the SQL query with filter conditions if filters are present
if (!empty($tugasFilter) || !empty($utsFilter) || !empty($uasFilter) || !empty($tugasAkhirFilter) || !empty($ipkFilter) || !empty($predikatFilter) || !empty($aboveAverageFilter) || !empty($belowAverageFilter)) {
    $query = "SELECT * FROM nilai_mahasiswa WHERE 1";

    if (!empty($tugasFilter)) {
        $query .= " AND tugas >= '$tugasFilter'";
    }

    if (!empty($utsFilter)) {
        $query .= " AND uts >= '$utsFilter'";
    }

    if (!empty($uasFilter)) {
        $query .= " AND uas >= '$uasFilter'";
    }
    
    if (!empty($tugasAkhirFilter)) {
        $query .= " AND tugas_akhir >= '$tugasAkhirFilter'";
    }

    if (!empty($ipkFilter)) {
        $query .= " AND ipk >= '$ipkFilter'";
    }

    if (!empty($predikatFilter)) {
        $query .= " AND predikat = '$predikatFilter'";
    }

    if (!empty($aboveAverageFilter)) {
        $query .= " AND ipk > (SELECT AVG(ipk) FROM nilai_mahasiswa)";
    }

    if (!empty($belowAverageFilter)) {
        $query .= " AND ipk < (SELECT AVG(ipk) FROM nilai_mahasiswa)";
    }

    $query .= ";";
} else {
    // If no filters, fetch all data
    $query = "SELECT * FROM nilai_mahasiswa;";
}

$sql = mysqli_query($conn, $query);
$no = 0;
?>

<!DOCTYPE html>
<html lang="en">

    <head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="favicon_io/site.webmanifest">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Mahasiswa - Database Ilmu</title>
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

        h2,
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

        .custom-form {
            display: flex;
            align-items: center;
        }

        .custom-form label {
            display: inline-block;
            width: 140px; /* Sesuaikan dengan kebutuhan */
            margin-right: 10px;
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container d-flex justify-content-between"> <!-- Align items on the right -->
            <a class="navbar-brand" href="#"><strong>Database Ilmu</strong> - Nilai Mahasiswa</a>
            <a href="landing.php" class="btn btn-outline-light">
                Keluar <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </nav>
    <div class="container">
        <h2 class="mt-4 text-center"><strong>Nilai Mahasiswa</strong></h2>
        <figure>
            <blockquote class="blockquote text-center">
                <p>Data Nilai Mahasiswa Semester x</p>
            </blockquote>
        </figure>
        
        <!-- ... (Any other elements you want to include, such as buttons or modals) ... -->

                <!-- Add Back Button -->
        <div class="d-flex justify-content-end mb-2">
            <a href="index.php" class="btn btn-outline-primary mb-0">
                <i class="fas fa-arrow-left"></i> Kembali ke Informasi Mahasiswa
            </a>
        </div>
        <div class="d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal"
                <?php echo (!empty($tugasFilter) || !empty($utsFilter) || !empty($uasFilter) || !empty($tugasAkhirFilter) || !empty($ipkFilter) || !empty($predikatFilter) || !empty($aboveAverageFilter) || !empty($belowAverageFilter)) ? 'data-filter-active="true"' : ''; ?>>
                Filter <i class="fas fa-filter"></i>
            </button>
        </div>

        <!-- ... (Sebelumnya PHP dan HTML) ... -->

        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Nilai Mahasiswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="nilai_mahasiswa.php" method="get">
                            <!-- Filter Nilai Tugas (Lebih Besar Dari) -->
                            <div class="mb-3 custom-form">
                                <label for="tugasFilter" class="form-label">Nilai Tugas <i class="fas fa-greater-than-equal"></i></label>
                                <input type="text" class="form-control" id="tugasFilter" name="tugas" value="<?php echo $tugasFilter; ?>">
                            </div>

                            <!-- Filter Nilai UTS ≥ -->
                            <div class="mb-3 custom-form">
                                <label for="utsFilter" class="form-label">Nilai UTS <i class="fas fa-greater-than-equal"></i></label>
                                <input type="text" class="form-control" id="utsFilter" name="uts" value="<?php echo $utsFilter; ?>">
                            </div>

                            <!-- Filter Nilai UAS ≥ -->
                            <div class="mb-3 custom-form">
                                <label for="uasFilter" class="form-label">Nilai UAS <i class="fas fa-greater-than-equal"></i></label>
                                <input type="text" class="form-control" id="uasFilter" name="uas" value="<?php echo $uasFilter; ?>">
                            </div>

                            <!-- Filter Nilai Tugas Akhir ≥ -->
                            <div class="mb-3 custom-form">
                                <label for="tugasAkhirFilter" class="form-label">Nilai Praktikum <i class="fas fa-greater-than-equal"></i></label>
                                <input type="text" class="form-control" id="tugasAkhirFilter" name="tugas_akhir" value="<?php echo $tugasAkhirFilter; ?>">
                            </div>

                            <div class="mb-3 custom-form">
                                <label for="ipkFilter" class="form-label">Nilai Akhir <i class="fas fa-greater-than-equal"></i></label>
                                <input type="text" class="form-control" id="ipkFilter" name="ipk" value="<?php echo $ipkFilter; ?>">
                            </div>

                            <!-- ... (Formulir filter sesuai dengan kebutuhan Anda) ... -->
                            <!-- <div class="mb-3 form-inline">
                                <label for="ipkStartFilter" class="form-label">Rentang IPK Awal</label>
                                <input type="text" class="form-control" id="ipkStartFilter" name="ipk_start" value="<?php echo $ipkStartFilter; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="ipkEndFilter" class="form-label">Rentang IPK Akhir</label>
                                <input type="text" class="form-control" id="ipkEndFilter" name="ipk_end" value="<?php echo $ipkEndFilter; ?>">
                            </div> -->
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="aboveAverageFilter" name="above_average" <?php echo ($aboveAverageFilter === '1') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="aboveAverageFilter">Nilai Akhir di atas rata-rata</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="belowAverageFilter" name="below_average" <?php echo ($belowAverageFilter === '1') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="belowAverageFilter">Nilai Akhir di bawah rata-rata</label>
                            </div>
                            <!-- Filter Predikat -->
                            <div class="mb-4">
                                <label for="predikatFilter" class="form-label">Predikat</label>
                                <select class="form-select" id="predikatFilter" name="predikat">
                                    <option value="">Semua</option>
                                    <option value="A" <?php echo ($predikatFilter === 'A') ? 'selected' : ''; ?>>A</option>
                                    <option value="A-" <?php echo ($predikatFilter === 'A-') ? 'selected' : ''; ?>>A-</option>
                                    <option value="B+" <?php echo ($predikatFilter === 'B+') ? 'selected' : ''; ?>>B+</option>
                                    <option value="B" <?php echo ($predikatFilter === 'B') ? 'selected' : ''; ?>>B</option>
                                    <option value="B-" <?php echo ($predikatFilter === 'B-') ? 'selected' : ''; ?>>B-</option>
                                    <option value="C+" <?php echo ($predikatFilter === 'C+') ? 'selected' : ''; ?>>C+</option>
                                    <option value="C" <?php echo ($predikatFilter === 'C') ? 'selected' : ''; ?>>C</option>
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
                        <th>Nama</th>
                        <th>Tugas</th>
                        <th>UTS</th>
                        <th>UAS</th>
                        <th>Praktikum</th>
                        <th>Nilai Akhir</th>
                        <th>Predikat</th>
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
                            <td><?php echo $result['nama_mahasiswa']; ?></td>
                            <td><?php echo $result['tugas']; ?></td>
                            <td><?php echo $result['uts']; ?></td>
                            <td><?php echo $result['uas']; ?></td>
                            <td><?php echo $result['tugas_akhir']; ?></td>
                            <td><?php echo $result['ipk']; ?></td>
                            <td><?php echo $result['predikat']; ?></td>
                            <td>
                                <center>
                                    <a href="edit_nilai.php?ubah=<?php echo $result['id_nilai']; ?>" type="button" class="btn btn-success">
                                        <i class="fas fa-edit"></i>
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
    
    <script>
    function resetFilter() {
        // Reset input values to empty
        document.getElementById('tugasFilter').value = '';
        document.getElementById('utsFilter').value = '';
        document.getElementById('uasFilter').value = '';
        document.getElementById('tugasAkhirFilter').value = '';
        document.getElementById('ipkFilter').value = '';
        document.getElementById('predikatFilter').value = '';
        document.getElementById('aboveAverageFilter').checked = false;
        document.getElementById('belowAverageFilter').checked = false;
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
                    "search": "Cari NPM/Nama:"
                    // Add more language options as needed
                },
                "columnDefs": [
                    { "searchable": false, "targets": [0, 3, 4, 5, 6, 7, 8] } // Menonaktifkan pencarian pada kolom 1, 5, 6, 7, dan 8
                ]
            });
        });
        </script>
</body>

</html>
