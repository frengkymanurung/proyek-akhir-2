<?php
session_start();

// Koneksi ke database (sesuaikan dengan informasi koneksi Anda)
require_once ('config.php');

// Fungsi untuk mendapatkan semua data registrasi pengguna
function getAllRegistrations($conn) {
    $query = "SELECT * FROM registrations";
    $result = mysqli_query($conn, $query);

    // Mengembalikan data registrasi dalam bentuk array asosiatif
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mengupdate status registrasi
function updateRegistrationStatus($conn, $registrationId, $status) {
    $query = "UPDATE registrations SET status = '$status' WHERE id = '$registrationId'";
    $result = mysqli_query($conn, $query);

    return $result;
}

// Mendapatkan semua data registrasi pengguna
$registrations = getAllRegistrations($conn);

// Memproses penolakan atau persetujuan registrasi jika ada permintaan dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registrationId = $_POST['registrationId'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $status = 'approved';
        $message = 'Registrasi berhasil disetujui!';
    } elseif ($action === 'reject') {
        $status = 'rejected';
        $message = 'Registrasi berhasil ditolak!';
    }

    // Update status registrasi
    $result = updateRegistrationStatus($conn, $registrationId, $status);

    if ($result) {
        $success = $message;
    } else {
        $error = 'Terjadi kesalahan. Gagal memperbarui status registrasi.';
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Persetujuan Registrasi Pengguna</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-top: 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        p.success-message {
            color: green;
            font-weight: bold;
        }

        p.error-message {
            color: red;
            font-weight: bold;
        }

        form {
            display: inline-block;
            margin: 0;
        }

        .button-container {
            margin-top: 20px;
        }

        .button-container button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Persetujuan Registrasi Pengguna</h1>
    <?php if (isset($success)): ?>
        <p class="success-message"><?php echo $success; ?></p>
    <?php elseif (isset($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrations as $registration): ?>
            <tr>
                <td><?php echo $registration['id']; ?></td>
                <td><?php echo $registration['username']; ?></td>
                <td><?php echo $registration['password']; ?></td>
                <td><?php echo $registration['email']; ?></td>
                <td><?php echo $registration['role']; ?></td>
                <td><?php echo $registration['status']; ?></td>
                <td>
                    <?php if ($registration['status'] === 'pending'): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="registrationId" value="<?php echo $registration['id']; ?>">
                            <button type="submit" name="action" value="approve" class="btn btn-success">Setujui</button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger">Tolak</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="button-container">
        <a href="index1.php" class="dashboard-link">
            <button class="btn btn-primary">Kembali ke Dashboard</button>
        </a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
