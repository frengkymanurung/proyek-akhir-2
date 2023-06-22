<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .content {
            padding: 20px;
        }

        .content h3 {
            text-align: center;
            margin-bottom: 30px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content table th,
        .content table td {
            padding: 12px;
            border: 1px solid #ccc;
        }

        .content table th {
            background-color: #f2f2f2;
        }

        .content table td {
            text-align: center;
        }

        .content table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .content table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h3>Daftar Ruangan</h3>
            <?php
            // Membuat koneksi ke database (gantikan sesuai dengan koneksi Anda)
            require_once ('config.php');

            // Mengambil data ruangan dari database
            $sql = "SELECT * FROM tabel_daftarruangan";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Menampilkan data ruangan dalam tabel
                echo "<table>
                        <thead>
                            <tr>
                                <th>Ruangan ID</th>
                                <th>Nama Ruangan</th>
                                <th>Status</th>
                                <th>IP Device</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row['ruangan_id']."</td>
                            <td>".$row['ruangan_name']."</td>
                            <td>".$row['status']."</td>
                            <td>".$row['ip_device']."</td>
                        </tr>";
                }
                echo "</tbody>
                    </table>";
            } else {
                echo "<p>Tidak ada data ruangan.</p>";
            }

            // Menutup koneksi
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
