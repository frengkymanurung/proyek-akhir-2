<?php
function tekanTombol() {
    // Ganti URL sesuai dengan website target
    $url = "https://www.example.com";

    // Ganti dengan selektor tombol yang sesuai pada website target
    $selector = "//button[@id='tombol-id']";

    // Membuat instance DOMDocument
    $dom = new DOMDocument();

    // Mengaktifkan error handling untuk menghindari pesan error yang tidak perlu
    libxml_use_internal_errors(true);

    // Mengambil halaman HTML
    $dom->loadHTMLFile($url);

    // Membuat instance DOMXPath berdasarkan DOMDocument
    $xpath = new DOMXPath($dom);

    // Menemukan tombol berdasarkan selektor
    $tombol = $xpath->query($selector)->item(0);

    // Menekan tombol
    if ($tombol) {
        $tombol->click();
    }
}

function jalankanSkrip($ulang, $waktu) {
    for ($i = 0; $i < $ulang; $i++) {
        tekanTombol();
        sleep($waktu);
    }
}

// Menjalankan skrip dengan parameter jumlah ulangan dan waktu antara setiap ulangan (dalam detik)
jalankanSkrip(5, 10);  // Contoh: menekan tombol 5 kali dengan jeda 10 detik
?>
