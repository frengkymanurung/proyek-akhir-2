<?php
require_once ('config.php');

// Memeriksa apakah ada permintaan POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Mengambil nilai booking_id dari permintaan
    $bookingId = $_POST["booking_id"];

    // Memperbarui status pemesanan menjadi "Disetujui" di database
    $sql = "UPDATE bookings SET status = 'Disetujui' WHERE id = $bookingId";
    if ($conn->query($sql) === TRUE) {
        // Mengembalikan ke halaman sebelumnya
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
