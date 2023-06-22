<?php
// Memulai sesi
session_start();

// Memanggil file config.php untuk menghubungkan ke database
require_once 'config.php';

// Query untuk mengambil data ruangan dari database
$query = "SELECT * FROM ruangan";
$result = $conn->query($query);

// Inisialisasi array untuk menyimpan data ruangan
$ruangan = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ruangan[] = $row;
    }
}

// Query untuk mengambil data user dari database berdasarkan username
$query_user = "SELECT * FROM registrations WHERE username = '$username'";
$result_user = $conn->query($query_user);

// Inisialisasi variabel untuk menyimpan data user
$user = null;

if ($result_user && $result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
}
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Table 09</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
    <link rel="stylesheet" href="css/style.css">


    <script>
        function toggleSidebar() {
            var sidebar = document.querySelector('.sidebar');
            var hamburger = document.querySelector('.hamburger');

            sidebar.classList.toggle('open');
            hamburger.classList.toggle('open');
        }
    </script>

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
            <div class="hamburger" onclick="toggleSidebar()">
					<span></span>
					<span></span>
					<span></span>
				</div>
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Daftar Ruangan</h2>
                    <p class="welcome">Selamat Datang</p>
                </div>
                <div class="logout-btn"> 
                    <a href="logout.php" class="btn btn-danger">Keluar</a>
                </div> 
       
				<div class="sidebar">
					<h3>Menu Dashboard</h3>
					<div class="dropdown">
						<a href="approve.php" class="dropdown-item">User</a>
					</div>
					<a href="menunggu.php" class="dropdown-item">List Request</a>
					<a href="ruangan2.php" class="dropdown-item">Ruangan</a>
					<a href="tambah_ruangan.php" class="dropdown-item">Tambah Ruangan</a>
				</div>
           
			</div>
			<div class="row">
                
				<div class="col-md-12">
					<div class="table-wrap">
                        <?php if (!empty($ruangan)): ?>
						<table class="table table-striped">
						  <thead>
                            <tr>
                                <th>Ruangan ID</th>
                                <th>Nama Ruangan</th>
                                <th>Status</th>
                                <th>IP Alat</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($ruangan as $r): ?>
                            <tr>
                                <td><?php echo $r['id_ruangan']; ?></td>
                                <td><?php echo $r['nama_ruangan']; ?></td>
                                <td><?php echo $r['status']; ?></td>
                                <td><?php echo $r['ip_device']; ?></td>
                            </tr>
                            
                        <?php endforeach; ?>
                          </tbody>
						</table>
                        <?php else: ?>
                <p>Tidak ada data ruangan.</p>
            <?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>

