<?php
// Konfigurasi koneksi ke database
require_once ('config.php');

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Mendapatkan data ruangan dari form
    $id_ruangan = $_POST["id_ruangan"];
    $nama_ruangan = $_POST["nama_ruangan"];
    $status = $_POST["status"];
    $ip_device = $_POST["ip_device"];

    // Menyimpan data ruangan ke tabel "ruangan"
    $sql = "INSERT INTO ruangan (id_ruangan, nama_ruangan, status, ip_device) VALUES ('$id_ruangan', '$nama_ruangan', '$status', '$ip_device')";

    if ($conn->query($sql) === TRUE) {
        $message = "Ruangan berhasil dibuat.";
        echo "<script>alert('$message');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Create Ruangan</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 20px;
            }

            .container {
                max-width: 400px;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .container h2 {
                margin-top: 0;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }

            .form-group input[type="text"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .form-group button {
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
            .dashboard-btn{
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
            .buttons{
                display:flex;
                justify-content: space-between;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Create Ruangan</h2>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <div class="form-group">
                    <label for="id_ruangan">ID Ruangan:</label>
                    <input type="text" id="id_ruangan" name="id_ruangan" required>
                </div>
                <div class="form-group">
                    <label for="nama_ruangan">Nama Ruangan:</label>
                    <input type="text" id="nama_ruangan" name="nama_ruangan" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" id="status" name="status" required>
                </div>
                <div class="form-group">
                    <label for="ip_device">IP Device:</label>
                    <input type="text" id="ip_device" name="ip_device" required>
                </div>
                <div class="buttons">
                <div class="form-group">
                    <button type="submit">Simpan</button>
                </div>

                <div class="dashboard-btn-container">
            <button class="dashboard-btn" onclick="window.location.href = 'index1.php';">Kembali ke Dashboard</button>
        </div>
        </div>
            </form>
        </div>
        
    </body>
    </html>
