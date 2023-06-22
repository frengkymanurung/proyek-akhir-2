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

    <style>
        /* CSS untuk ruangan, nama ruangan, dan status */
.table-wrap table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.table-wrap th, .table-wrap td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.table-wrap th {
  background-color: #f2f2f2;
}

.profile {
  margin-top: 10px;
  text-align: center;
}

.logout-btn {
  text-align: center;
  margin-top: 10px;
}

.logout-btn .btn {
  padding: 10px 20px;
}



    </style>

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Daftar Ruangan</h2>
                    <p class="welcome">Welcome</p>
				
				<div class="hamburger" onclick="toggleSidebar()">
					<span></span>
					<span></span>
					<span></span>
				</div>
                </div>
				<div class="sidebar">
					<h3>Menu Dashboard</h3>
					<div class="dropdown">
						
					</div>
					<a href="pesanan_diterima.php" class="dropdown-item">List Ruangan</a>
					<a href="ruangan.php" class="dropdown-item">Daftar Ruangan</a>
</div>
                <div class="logout-btn">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
                    <?php 
            require_once ('config.php');

            // Retrieve data from the "ruangan" table
            $sql = "SELECT * FROM ruangan";
            $result = $conn->query($sql);

            // Check if any rows are returned
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Ruangan ID</th>";
                echo "<th>Nama Ruangan</th>";
                echo "<th>Status</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_ruangan"] . "</td>";
                    echo "<td>" . $row["nama_ruangan"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>Tidak ada data ruangan.</p>";
            }

            // Close the database connection
            $conn->close();
            ?>
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

