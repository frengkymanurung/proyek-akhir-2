<!DOCTYPE html>
<html>
<head>
    <title>Tampilan Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
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

        h2 {
            margin-top: 20px;
        }

        .no-booking-message {
            margin-top: 20px;
            font-weight: bold;
            color: #888;
        }

        .back-button {
            margin-top: 20px;
        }

        .back-button a {
            display: inline-block;
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .back-button a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php
    // Konfigurasi koneksi ke database
    require_once ('config.php');

    // Mengambil data pemesanan dari tabel "bookings"
    $sql = "SELECT * FROM bookings";
    $result = $conn->query($sql);

    // Menampilkan data pemesanan
    if ($result->num_rows > 0) {
        echo "<h2>Daftar Pemesanan:</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Nama</th><th>Email</th><th>Tanggal Booking</th><th>Waktu Mulai</th><th>Waktu Selesai</th><th>Ruangan</th><th>Catatan Tambahan</th><th>Created At</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["nama"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["tanggal_booking"] . "</td>";
            echo "<td>" . $row["waktu_mulai"] . "</td>";
            echo "<td>" . $row["waktu_selesai"] . "</td>";
            echo "<td>" . $row["ruangan"] . "</td>";
            echo "<td>" . $row["catatan_tambahan"] . "</td>";
            echo "<td>" . $row["created_at"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-booking-message'>Belum ada data pemesanan.</p>";
    }

    $conn->close();
    ?>

    <div class="back-button">
        <a href="index1.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>
