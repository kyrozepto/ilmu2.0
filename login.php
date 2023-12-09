<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db_username = "databaseilmu";
    $db_password = "belanegara";

    if ($username == $db_username && $password == $db_password) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page Ilmu UPNVJT</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Raleway', sans-serif;
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #28a745; /* Dark Gray Background */
            color: #ffffff; /* White Text */
            font-size: 24px;
        }

        .login-container {
            margin-top: 30px; /* Adjusted margin for better spacing */
        }

        .form-label {
            color: #28a745;
        }

        .form-control {
            border: 1px solid #28a745;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #ffffff;
            color: #28a745;
            border: 1px solid #28a745;
        }

        .btn-primary:hover {
            background-color: #28a745;
        }

        .alert-danger {
            border: 1px solid #dc3545;
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Database Ilmu</h1>
    </div>

    <div class="container">
        <div class="row justify-content-center login-container">
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <?php
                            if (isset($error_message)) {
                                echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
                            }
                            ?>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>
