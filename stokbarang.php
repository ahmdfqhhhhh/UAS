<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "belajar";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_barang = trim($_POST['id_barang'] ?? '');
$nama_barang = trim($_POST['nama_barang'] ?? '');
$jumlah_kurang = intval($_POST['jumlah']);

$message = "";
$status = "";

// Validasi input
if ($id_barang === '' && $nama_barang === '') {
    $message = "❌ Harap isi salah satu: ID Barang atau Nama Barang.";
    $status = "error";
} else {
    // Bangun query pencarian dinamis
    if ($id_barang !== '') {
        $sql = "SELECT * FROM barang WHERE id_barang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id_barang);
    } else {
        $sql = "SELECT * FROM barang WHERE nama_barang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nama_barang);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stok_sekarang = $row['stok'];
        $id_barang = $row['id_barang']; // Tetapkan ID sebenarnya jika nama digunakan

        if ($jumlah_kurang <= $stok_sekarang) {
            $stok_baru = $stok_sekarang - $jumlah_kurang;
            $update = $conn->prepare("UPDATE barang SET stok = ? WHERE id_barang = ?");
            $update->bind_param("is", $stok_baru, $id_barang);

            if ($update->execute()) {
                $message = "✅ Stok barang <strong>{$row['nama_barang']}</strong> berhasil dikurangi.<br>Stok baru: <strong>$stok_baru</strong>.";
                $status = "success";
            } else {
                $message = "❌ Gagal mengurangi stok.";
                $status = "error";
            }

            $update->close();
        } else {
            $message = "⚠️ Jumlah pengurangan melebihi stok yang tersedia (<strong>$stok_sekarang</strong>).";
            $status = "warning";
        }
    } else {
        $message = "❌ Barang tidak ditemukan.";
        $status = "error";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Hasil Pengurangan Stok Barang</title>
  <link rel="icon" type="image/png" href="logostruk.png">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9fafb;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .result-box {
      background-color: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 400px;
    }

    .result-box.success { border-left: 5px solid #10b981; }
    .result-box.warning { border-left: 5px solid #f59e0b; }
    .result-box.error { border-left: 5px solid #ef4444; }

    h3 {
      margin-bottom: 15px;
      color: #111827;
    }

    p {
      font-size: 1.1rem;
      color: #374151;
    }

    a {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #2563eb;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="result-box <?= $status ?>">
    <h3>Hasil Proses</h3>
    <p><?= $message ?></p>
    <a href="stokbarang.html">← Kembali</a>
  </div>
</body>
</html>
