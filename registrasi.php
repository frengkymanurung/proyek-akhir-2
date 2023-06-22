<?php
session_start();

// Koneksi ke database (sesuaikan dengan informasi koneksi Anda)
require_once ('config.php');

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Periksa apakah username sudah ada dalam database
    $query = "SELECT * FROM registrations WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Username sudah digunakan, tampilkan pesan kesalahan
        $error = 'Username sudah digunakan!';
    } else {
        // Tambahkan akun pengguna dengan status "pending"
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO registrations (username, password, email, status, role) VALUES (?, ?, ?, 'pending', 'user')";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $hashedPassword, $email);
        mysqli_stmt_execute($stmt);

        // Registrasi berhasil, alihkan pengguna ke halaman login
        header('Location: login.php');
        exit();
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 400px;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-group input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-group .login-link {
            display: block;
            margin-top: 10px;
            text-align: center;
        }

        .form-group .login-link a {
            color: #337ab7;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrasi</h1>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Register">
            </div>
        </form>
        <div class="form-group">
            <p class="login-link">Sudah memiliki akun? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
