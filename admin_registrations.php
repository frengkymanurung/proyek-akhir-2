<?php
session_start();

require_once ('config.php');
// Fungsi untuk mendapatkan daftar registrasi pengguna yang belum disetujui
function getPendingRegistrations($conn) {
    $query = "SELECT * FROM registrations WHERE status = 'pending'";
    $result = mysqli_query($conn, $query);

    return $result;
}

// Fungsi untuk menyetujui registrasi pengguna
function approveRegistration($conn, $registrationId) {
    $query = "UPDATE registrations SET status = 'approved' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $registrationId);
    $result = mysqli_stmt_execute($stmt);

    return $result;
}

// Fungsi untuk menolak registrasi pengguna
function rejectRegistration($conn, $registrationId) {
    $query = "DELETE FROM registrations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $registrationId);
    $result = mysqli_stmt_execute($stmt);

    return $result;
}

// Memeriksa apakah pengguna telah login sebagai admin
function checkAdminRole() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        // Jika peran bukan admin, alihkan pengguna ke halaman tidak diizinkan
        header('Location: unauthorized.php');
        exit();
    }
}

// Proses penolakan registrasi
if (isset($_GET['reject']) && $_GET['reject'] !== '') {
    checkAdminRole();
    $registrationId = $_GET['reject'];

    // Tolak registrasi pengguna
    $rejectResult = rejectRegistration($conn, $registrationId);

    if ($rejectResult) {
        // Registrasi berhasil ditolak
        $successMessage = 'Registrasi berhasil ditolak.';
    } else {
        // Registrasi gagal ditolak
        $errorMessage = 'Gagal menolak registrasi. Silakan coba lagi.';
    }
}

// Proses penerimaan registrasi
if (isset($_GET['approve']) && $_GET['approve'] !== '') {
    checkAdminRole();
    $registrationId = $_GET['approve'];

    // Setujui registrasi pengguna
    $approveResult = approveRegistration($conn, $registrationId);

    if ($approveResult) {
        // Registrasi berhasil disetujui
        $successMessage = 'Registrasi berhasil disetujui.';
    } else {
        // Registrasi gagal disetujui
        $errorMessage = 'Gagal menyetujui registrasi. Silakan coba lagi.';
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Registrasi Pengguna</title>
</head>
<body>
    <h1>Admin - Registrasi Pengguna</h1>

    <?php if (isset($successMessage)): ?>
        <p style="color: green;"><?php echo $successMessage; ?></p>
    <?php elseif (isset($errorMessage)): ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <?php
    // Mendapatkan daftar registrasi pengguna yang belum disetujui
    $registrations = getPendingRegistrations($conn);

    if (mysqli_num_rows($registrations) > 0):
    ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($registrations)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="?approve=<?php echo $row['id']; ?>">Setujui</a>
                        <a href="?reject=<?php echo $row['id']; ?>">Tolak</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Tidak ada registrasi pengguna yang belum disetujui.</p>
    <?php endif; ?>
</body>
</html>
