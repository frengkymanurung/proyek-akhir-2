<?php
// Konfigurasi koneksi ke database
require_once('config.php');

// Cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    // Mengambil nilai dari form pemesanan ruangan
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $tanggalBooking = $_POST['tanggalBooking'];
    $waktuMulai = $_POST['waktuMulai'];
    $waktuSelesai = $_POST['waktuSelesai'];
    $ruangan = $_POST['ruangan'];
    $catatanTambahan = $_POST['catatanTambahan'];

    // Menyiapkan pernyataan SQL untuk menyimpan data pemesanan ruangan
    $sql = "INSERT INTO bookings (nama, email, tanggal_booking, waktu_mulai, waktu_selesai, ruangan, catatan_tambahan)
            VALUES ('$nama', '$email', '$tanggalBooking', '$waktuMulai', '$waktuSelesai', '$ruangan', '$catatanTambahan')";

    if ($conn->query($sql) === TRUE) {
        $message = "Pemesanan ruangan berhasil disimpan.";
        echo "<script>alert('$message');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Pemesanan Ruangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        /* CSS styling */

        h1 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            margin-bottom: 16px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"],
        .dashboard-btn {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        .dashboard-btn:hover {
            background-color: #45a049;
        }

        .dashboard-btn {
            background-color: #337ab7;
        }

        .dashboard-btn-container {
            text-align: center;
            margin-top: 20px;
        }

        /* Custom CSS styling for select element */
        .select-container {
            position: relative;
        }

        .select-container::after {
            content: '\25BC';
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .select-container select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding-right: 30px;
            background-color: #fff;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            padding: 10px;
        }

        /* Custom styling for select dropdown arrow */
        .select-container::before {
            content: '';
            position: absolute;
            top: 50%;
            right: 8px;
            transform: translateY(-50%);
            border-top: 6px solid #aaa;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
        }

        .submit-container {
            text-align: center;
            margin-top: 20px;
        }

        .submit-container input[type="submit"] {
            display: inline-block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h1>Form Pemesanan Ruangan</h1>
    <form method="POST" action="">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="tanggalBooking">Tanggal Booking:</label>
        <input type="date" name="tanggalBooking" id="tanggalBooking" required>

        <label for="waktuMulai">Waktu Mulai:</label>
        <input type="time" name="waktuMulai" id="waktuMulai" required>

        <label for="waktuSelesai">Waktu Selesai:</label>
        <input type="time" name="waktuSelesai" id="waktuSelesai" required>

        <label for="ruangan">Ruangan yang Dipilih:</label>
        <div class="select-container">
            <select name="ruangan" id="ruangan" required>
                <?php
                // Mengambil data ruangan dari tabel "ruangan"
                $sql = "SELECT * FROM ruangan";
                $result = $conn->query($sql);

                // Menampilkan opsi ruangan
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["nama_ruangan"] . "'>" . $row["nama_ruangan"] . "</option>";
                    }
                } else {
                    echo "<option value=''>Tidak ada ruangan tersedia</option>";
                }
                ?>
            </select>
        </div>

        <label for="catatanTambahan">Catatan Tambahan:</label>
        <textarea name="catatanTambahan" id="catatanTambahan"></textarea>

        <div class="submit-container">
            <input type="submit" name="submit" value="Submit">
        </div>

        <div class="dashboard-btn-container">
            <button class="dashboard-btn" onclick="window.location.href = 'index.php';">Kembali ke Dashboard</button>
        </div>
    </form>
</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>
