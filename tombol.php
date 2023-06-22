<?php
// Mendefinisikan alamat IP Arduino
$arduinoIP1 = '172.27.40.8'; // Ganti dengan alamat IP Arduino pertama Anda
$arduinoIP2 = '172.27.42.146'; // Ganti dengan alamat IP Arduino kedua Anda

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
if (isset($_POST['turnOnDoor1'])) {
    $url = 'http://' . $arduinoIP1 . '/door1/on';
    $response = sendRequestToArduino($url);
    echo "Door 1 turned ON.";
} elseif (isset($_POST['turnOffDoor1'])) {
    $url = 'http://' . $arduinoIP1 . '/door1/off';
    $response = sendRequestToArduino($url);
    echo "Door 1 turned OFF.";
}

if (isset($_POST['turnOnDoor2'])) {
    $url = 'http://' . $arduinoIP2 . '/3/on';
    $response = sendRequestToArduino($url);
    echo "Door 2 turned OFF.";
} elseif (isset($_POST['turnOffDoor2'])) {
    $url = 'http://' . $arduinoIP2 . '/3/off';
    $response = sendRequestToArduino($url);
    echo "Door 2 turned ON.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Control GPIO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
        }
        
        h1 {
            color: #333;
        }
        
        .container {
            margin-top: 100px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Control GPIO</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <!-- <input class="btn" type="submit" name="turnOffDoor1" value="Door 1 ON">
            <input class="btn" type="submit" name="turnOnDoor1" value="Door 1 OFF"> -->
            <br><br>
            <input class="btn" type="submit" name="turnOffDoor2" value="Door 2 ON">
            <input class="btn" type="submit" name="turnOnDoor2" value="Door 2 OFF">
            
            
        </form>
    </div>
</body>
</html>
