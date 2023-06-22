<!DOCTYPE html>
<html>
<head>
    <title>Tampilan Ruangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            margin-top: 0;
            text-align:center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .dashboard-btn-container {
            margin-top: 20px;
            text-align: left;
        }

        .dashboard-btn {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn-buka {
            background-color: #4caf50;
        }

        .btn-tutup {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Ruangan</h2>
        <hr>
        <?php
        // Konfigurasi koneksi ke database
        require_once('config.php');

        // Mendapatkan data ruangan dari tabel "ruangan"
        $sql = "SELECT * FROM ruangan";
        $result = $conn->query($sql);

        // Memeriksa apakah terdapat data ruangan
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID Ruangan</th><th>Nama Ruangan</th><th>Status</th></tr>";

            // Menampilkan data ruangan
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_ruangan"] . "</td>";
                echo "<td>" . $row["nama_ruangan"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Tidak ada ruangan yang tersedia.</p>";
        }

        $conn->close();
        ?>

        <div class="dashboard-btn-container">
            <button class="dashboard-btn" onclick="window.location.href = 'index.php';">Dashboard</button>
            <button class="dashboard-btn" onclick="window.location.href = 'booking.php';">Booking</button>
        </div>
    </div>

    <script>
        function bukaRuangan(idRuangan) {
            // Lakukan aksi untuk membuka ruangan dengan ID yang diberikan
            console.log("Membuka ruangan dengan ID: " + idRuangan);
            alert("Ruangan dengan ID " + idRuangan + " dibuka.");
        }
    </script>
</body>
</html>
