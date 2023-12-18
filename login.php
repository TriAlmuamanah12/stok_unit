<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>Login & Logout PHP</title>
    <style>
        body {
            background: url('background-image.jpg') center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #828282;
        }
        
        .error-message {
            background-color: #FF5733;
            color: white;
        }
        
        .success-message {
            background-color: #33FF61;
            color: white;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            background: linear-gradient(to bottom, #3498db, #2980b9);
        }
        
        .card-header {
            background-color: transparent;
            text-align: center;
            padding: 20px 0;
        }
        
        .card-header img {
            max-width: 150px;
            max-height: 150px;
            display: block;
            margin: 0 auto;
            border-radius: 50%;
            background-color: #fff;
            padding: 10px;
        }
        
        .card-header h1 {
            color: #fff;
            font-size: 24px;
        }
        
        .form-group label {
            color: #333;
        }
        
        .form-control {
            border-color: #ccc;
            border-radius: 25px;
            padding: 15px;
        }
        
        .form-control:focus {
            border-color: #e74c3c;
        }
        
        .form-control::placeholder {
            color: #666;
        }
        
		a {
			color: #000;
			text-decoration: none;
			background-color: transparent;
		
		}
        .btn-primary {
            font-weight: bold;
            background-color: #e74c3c;
            color: #fff;
            border-radius: 25px;
            padding: 10px 20px;
            transition: background-color 0.3s, border-color 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <?php
                session_start();
                $login_success = false; // Inisialisasi variabel
                $username = ""; // Inisialisasi variabel
                $createdBy = ""; // Inisialisasi variabel

                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
                    unset($_SESSION['error']);
                }

                // Pastikan Anda memiliki kondisi yang sesuai untuk $login_success, $username, dan $createdBy
                if ($login_success) {
                    $_SESSION['username'] = $username;
                    $_SESSION['CreatedBy'] = $createdBy;

                    header("Location: index.php");
                    exit;
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <img src="dist/img/logo.png" alt="Logo"> <!-- Ganti URL gambar sesuai kebutuhan -->
                        <h1 class="mt-3">Login</h1>
                    </div>
                    <div class="card-body">
                        <form action="process.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" aria-describedby="username" placeholder="Username" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="show_password" onchange="togglePassword()">
                                <label class="form-check-label" for="show_password">Show Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Taruh script JavaScript Anda di sini -->
    <script>
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var showPasswordCheckbox = document.getElementById('show_password');

            if (showPasswordCheckbox.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        }
    </script>
</body>
</html>