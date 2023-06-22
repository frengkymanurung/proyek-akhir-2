<?php
session_start();

// Fungsi untuk memeriksa peran pengguna
function checkRole($allowedRoles) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles)) {
        // Jika peran tidak sesuai, alihkan pengguna ke halaman tidak diizinkan
        header('Location: unauthorized.php');
        exit();
    }
}

// Koneksi ke database (sesuaikan dengan informasi koneksi Anda)
require_once ('config.php');

// Fungsi untuk memeriksa keberadaan username dalam database
function usernameExists($conn, $username) {
    $query = "SELECT * FROM registrations WHERE username = ? AND status = 'approved'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    return mysqli_stmt_num_rows($stmt) > 0;
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lakukan validasi login (misalnya, periksa username dan password di database)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Periksa apakah username dan password cocok dalam database yang sudah disetujui
    if (usernameExists($conn, $username)) {
        $query = "SELECT * FROM registrations WHERE username = ? AND status = 'approved'";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $registration = mysqli_fetch_assoc($result);

        if (password_verify($password, $registration['password'])) {
            // Login berhasil, simpan informasi peran pengguna ke dalam session
            $_SESSION['role'] = $registration['role'];

            // Alihkan pengguna ke halaman dashboard sesuai peran
            if ($registration['role'] === 'admin') {
                header('Location: index1.php');
            } elseif ($registration['role'] === 'user') {
                header('Location: index.php');
            } else {
                // Peran tidak valid, tampilkan pesan kesalahan
                $error = 'Peran pengguna tidak valid!';
            }
            exit();
        } else {
            // Password salah, tampilkan pesan kesalahan
            $error = 'Password salah!';
        }
    } else {
        // Username tidak ditemukan atau belum disetujui, tampilkan pesan kesalahan
        $error = 'Username tidak valid atau belum disetujui!';
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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

        .form-group .register-link {
            display: block;
            margin-top: 10px;
            text-align: center;
        }

        .form-group .register-link a {
            color: #337ab7;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
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
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="form-group">
            <p class="register-link">Belum memiliki akun? <a href="registrasi.php">Registrasi</a></p>
        </div>
    </div>
</body>
</html>
