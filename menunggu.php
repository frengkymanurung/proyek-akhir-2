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
        echo "<tr><th>ID</th><th>Nama</th><th>Email</th><th>Tanggal Booking</th><th>Waktu Mulai</th><th>Waktu Selesai</th><th>Ruangan</th><th>Catatan Tambahan</th><th>Created At</th><th>Status</th><th>Action</th></tr>";
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

            // Menampilkan status dengan warna yang berbeda berdasarkan nilai kolom "status"
            $statusClass = "";
            switch ($row["status"]) {
                case "Disetujui":
                    $statusClass = "status-terima";
                    break;
                case "Ditolak":
                    $statusClass = "status-tolak";
                    break;
                default:
                    break;
            }

            echo "<td class='$statusClass'>" . $row["status"] . "</td>";

            echo "<td>";
            echo "<div class='action-buttons'>";

            // Menampilkan tombol "Terima" jika status belum disetujui atau ditolak
            if ($row["status"] !== "Disetujui" && $row["status"] !== "Ditolak") {
                echo "<form method='POST' action='terima.php'>";
                echo "<input type='hidden' name='booking_id' value='" . $row["id"] . "'>";
                echo "<input type='submit' name='terima' value='Terima'>";
                echo "</form>";
            }

            echo "</div>";
            echo "<div class='action-buttons'>";

            // Menampilkan tombol "Tolak" jika status belum disetujui atau ditolak
            if ($row["status"] !== "Disetujui" && $row["status"] !== "Ditolak") {
                echo "<form method='POST' action='tolak.php'>";
                echo "<input type='hidden' name='booking_id' value='" . $row["id"] . "'>";
                echo "<input type='submit' name='tolak' value='Tolak'>";
                echo "</form>";
            }

            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-booking-message'>Belum ada data pemesanan.</p>";
    }

    $conn->close();
    ?>
<!DOCTYPE html>
<html>
<head>
    <title>Tampilan Pemesanan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        .status-terima {
            color: green;
        }

        .status-tolak {
            color: red;
        }

        .action-buttons {
            display: flex;
            margin-right: 5px;
        }

        .action-buttons form {
            margin: 0;
        }

        .action-buttons input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .action-buttons input[type="submit"]:hover {
            background-color: #45a049;
        }

        .no-booking-message {
            margin-top: 20px;
            font-weight: bold;
            color: #888;
        }

        .back-button {
            margin-top: 20px;
            text-align: center;
        }

        .back-button a {
            text-decoration: none;
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
  <br><br>
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
