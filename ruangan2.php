<!DOCTYPE html>
<html>
<head>
    <title>Tampilan Ruangan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        p {
            font-weight: bold;
        }

        .container h2 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
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
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn {
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
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tampilan Ruangan</h2>
        <?php
        // Konfigurasi koneksi ke database
        require_once('config.php');

        // Mendapatkan data ruangan dari tabel "ruangan"
        $sql = "SELECT id_ruangan, nama_ruangan, ip_device FROM ruangan";
        $result = $conn->query($sql);

        // Memeriksa apakah terdapat data ruangan
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID Ruangan</th><th>Nama Ruangan</th><th>IP Device</th></tr>";

            // Menampilkan data ruangan
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_ruangan"] . "</td>";
                echo "<td>" . $row["nama_ruangan"] . "</td>";
                echo "<td>" . $row["ip_device"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Tidak ada ruangan yang tersedia.</p>";
        }

        $conn->close();

        // Mendefinisikan alamat IP Arduino
        $arduinoIP1 = '192.168.119.252'; // Ganti dengan alamat IP Arduino pertama Anda
        $arduinoIP2 = '192.168.119.252'; // Ganti dengan alamat IP Arduino kedua Anda

        // Fungsi untuk mengirim permintaan HTTP ke Arduino dan mengembalikan respons
        function sendRequestToArduino($url)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }

        // Mendeteksi tombol yang ditekan pada halaman PHP
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['toggleDoor1'])) {
                $status = $_POST['toggleDoor1'];
                $url = 'http://' . $arduinoIP1 . '/3/' . $status;
                $response = sendRequestToArduino($url);
                echo "<script>alert('Ruang Telah " . ($status == 'on' ? 'BUKA' : 'TUTUP') . "');</script>";
            }

            if (isset($_POST['toggleDoor2'])) {
                $status = $_POST['toggleDoor2'];
                $url = 'http://' . $arduinoIP2 . '/3/' . $status;
                $response = sendRequestToArduino($url);
                echo "<script>alert('Ruang Telah " . ($status == 'on' ? 'BUKA' : 'TUTUP') . "');</script>";
            }
        }
        ?>

        <div class="container">
            <p>Aksi</p>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <button class="btn" type="submit" name="toggleDoor1" value="<?php echo (isset($_POST['toggleDoor1']) && $_POST['toggleDoor1'] == 'on') ? 'off' : 'on'; ?>"> lab cisco <?php echo (isset($_POST['toggleDoor1']) && $_POST['toggleDoor1'] == 'on') ? 'TUTUP' : 'BUKA'; ?></button>
                <br><br>
                <button class="btn" type="submit" name="toggleDoor2" value="<?php echo (isset($_POST['toggleDoor2']) && $_POST['toggleDoor2'] == 'on') ? 'off' : 'on'; ?>">lab komputer <?php echo (isset($_POST['toggleDoor2']) && $_POST['toggleDoor2'] == 'on') ? 'TUTUP' : 'BUKA'; ?></button>
            </form>
        </div>
        <div class="dashboard-btn-container">
            <button class="dashboard-btn" onclick="window.location.href = 'index1.php';">Kembali ke Dashboard</button>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>