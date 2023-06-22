<?php
session_start();

// Koneksi ke database (sesuaikan dengan informasi koneksi Anda)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'doorlocksystem';

$conn = mysqli_connect($host, $username, $password, $database);

// Fungsi untuk memeriksa keberadaan username dalam database
function usernameExists($conn, $username) {
    $query = "SELECT * FROM registrations WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    return mysqli_num_rows($result) > 0;
}

// Fungsi untuk menyimpan registrasi ke database dengan status "Menunggu Konfirmasi"
function saveRegistration($conn, $username, $password, $email, $status) {
    $query = "INSERT INTO registrations (username, password, email, status) VALUES ('$username', '$password', '$email', '$status')";
    $result = mysqli_query($conn, $query);

    return $result;
}

// Fungsi untuk mengupdate status registrasi menjadi "Diterima"
function acceptRegistration($conn, $username) {
    $query = "UPDATE registrations SET status = 'Diterima' WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    return $result;
}

// Fungsi untuk mengupdate status registrasi menjadi "Ditolak"
function rejectRegistration($conn, $username) {
    $query = "UPDATE registrations SET status = 'Ditolak' WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    return $result;
}

// Fungsi untuk mendapatkan semua user yang melakukan registrasi dengan status "Menunggu Konfirmasi"
function getPendingUsers($conn) {
    $query = "SELECT * FROM registrations WHERE status = 'Menunggu Konfirmasi'";
    $result = mysqli_query($conn, $query);

    // Mengembalikan data user dalam bentuk array
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input (misalnya, periksa keberadaan username dan password)
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $status = 'Menunggu Konfirmasi'; // Set status awal registrasi menjadi "Menunggu Konfirmasi"

    // Cek apakah username sudah ada dalam database
    if (usernameExists($conn, $username)) {
        $error = 'Username sudah digunakan!';
    } else {
        // Lakukan proses registrasi dan simpan ke database registrations dengan status "Menunggu Konfirmasi"
        $result = saveRegistration($conn, $username, $password, $email, $status);

        if ($result) {
            // Registrasi berhasil, tampilkan pesan sukses
            $success = 'Registrasi berhasil! Menunggu konfirmasi.';
        } else {
            // Registrasi gagal, tampilkan pesan kesalahan
            $error = 'Registrasi gagal. Silakan coba lagi.';
        }
    }
}

// Proses menerima registrasi
if (isset($_GET['accept'])) {
    $username = $_GET['accept'];
    $result = acceptRegistration($conn, $username);

    if ($result) {
        $success = 'Registrasi berhasil diterima!';
    } else {
        $error = 'Gagal menerima registrasi. Silakan coba lagi.';
    }
}

// Proses menolak registrasi
if (isset($_GET['reject'])) {
    $username = $_GET['reject'];
    $result = rejectRegistration($conn, $username);

    if ($result) {
        $success = 'Registrasi berhasil ditolak!';
    } else {
        $error = 'Gagal menolak registrasi. Silakan coba lagi.';
    }
}

// Mendapatkan semua user yang melakukan registrasi dengan status "Menunggu Konfirmasi"
$pendingUsers = getPendingUsers($conn);

// Tutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Pengguna</title>
</head>
<body>

    <h2>Daftar User Menunggu Konfirmasi</h2>
    <?php if (!empty($pendingUsers)): ?>
        <ul>
            <?php foreach ($pendingUsers as $user): ?>
                <li><?php echo $user['username']; ?> - <?php echo $user['email']; ?></li>
                <a href="?accept=<?php echo $user['username']; ?>">Terima</a> |
                <a href="?reject=<?php echo $user['username']; ?>">Tolak</a>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Tidak ada user yang menunggu konfirmasi.</p>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php elseif (isset($success)): ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>

    <h2>Daftar User Diterima</h2>
    <?php
    // Membuat koneksi ke database
    $servername = "nama_server";
    $username = "nama_pengguna";
    $password = "kata_sandi";
    $dbname = "nama_database";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM registrations WHERE status = 'Diterima'";
    $result = mysqli_query($conn, $query);
    $acceptedUsers = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!empty($acceptedUsers)) {
        echo "<ul>";
        foreach ($acceptedUsers as $user) {
            echo "<li>".$user['username']."</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Tidak ada user yang diterima.</p>";
    }

    // Menutup koneksi
    mysqli_close($conn);
?>

</body>
</html>
