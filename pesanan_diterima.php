<!DOCTYPE html>
<html>
<head>
    <title>Pemesanan Diterima</title>
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
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px 16px;
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

        .dashboard-button {
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
            transition: background-color 0.3s ease;
        }

        .dashboard-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Daftar Ruangan yang Sudah Terpesan:</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Tanggal Booking</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Ruangan</th>
            <th>Catatan Tambahan</th>
            <th>Created At</th>
        </tr>
        <?php
            // Fungsi untuk mengirimkan permintaan HTTP ke URL
            function sendRequestToArduino($url) {
                // Inisialisasi CURL
                $curl = curl_init();

                // Set opsi CURL
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                // Mengirimkan permintaan GET ke URL
                $response = curl_exec($curl);

                // Menutup CURL
                curl_close($curl);

                // Mengembalikan respons dari permintaan
                return $response;
            }

            // Konfigurasi koneksi ke database
            require_once('config.php');

            // Mengambil data pemesanan dari tabel "bookings"
            $sql = "SELECT * FROM bookings WHERE status = 'Disetujui'";
            $result = $conn->query($sql);

            // Menampilkan data pemesanan
            if ($result->num_rows > 0) {
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
            }

            $conn->close();
        ?>
    </table>

    <button class="dashboard-button" onclick="window.location.href = 'index.php';">Dashboard</button>
</body>
</html>
