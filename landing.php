<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="favicon_io/site.webmanifest">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Ilmu</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700&display=swap">
    <style>
        body {
            background-color: #28a745; /* Green Background */
            color: #ffffff; /* White Text */
            font-family: 'Raleway', sans-serif; /* Raleway font */
            text-align: center;
            padding: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            opacity: 0;
            animation: fadeIn 0.4s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        h1 {
            font-size: 3em;
        }

        p {
            font-size: 1.2em;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
            margin-bottom: 25px;
        }

        strong {
            font-weight: bold;
        }

        .btn-success {
            background-color: #ffffff; /* White Button Background */
            color: #28a745; /* Green Button Text */
            border-color: #ffffff; /* White Button Border */
        }

        .info-icon {
            cursor: pointer;
            position: fixed;
            top: 20px;
            left: 30px;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <div>
        <h1><strong>Database_Ilmu</strong></h1>
        <p id="dynamicText">Temukan informasi mahasiswa dengan mudah.</p>
        <a href="index.php" class="btn btn-success">Masuk ke website <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        <!-- <span class="info-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Website ini bagian dari perkuliahan basis data lanjut.">
            <i class="fa-solid fa-info-circle"></i>
        </span> -->
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dynamicText = document.getElementById('dynamicText');
            var phrases = [
                '<i class="fa-solid fa-magnifying-glass"></i> Cari data mahasiswa aktif 2023.',
                'Ubah informasi pada mahasiswa.',
                '<i class="fa-solid fa-check"></i> Input nilai perkuliahan mahasiswa.',
                'Filter berdasarkan atribut mahasiswa.',
                // Tambahkan lebih banyak kata atau frase sesuai kebutuhan
            ];

            var index = 0;

            function changeText() {
                dynamicText.style.opacity = 0;
                setTimeout(function () {
                    dynamicText.innerHTML = phrases[index];
                    dynamicText.style.opacity = 1;
                    index = (index + 1) % phrases.length;
                }, 400); // Waktu transisi setelah opacity menjadi 0 (0.5 detik)
            }

            setInterval(changeText, 2700); // Ganti setiap 3 detik (3000 milidetik)

            // Initialize Bootstrap tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('.info-icon'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>
