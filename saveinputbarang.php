<!DOCTYPE html>
<html>
<head>
    <title>Informasi Data Barang</title>
    <link rel="icon" type="image/png" href="logostruk.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        center {
            margin-top: 50px;
        }
        font {
            color: #333;
        }
        hr {
            border: 1px solid #ccc;
        }
        .button-container {
            margin-top: 30px;
        }
        .btn {
            background-color: #4CAF50; /* Hijau */
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-danger {
            background-color: #f44336; /* Merah */
        }
        .btn-danger:hover {
            background-color: #da190b;
        }
        .message {
            font-size: 18px;
            color: #333;
            margin-top: 20px;
        }
        .warning {
            color: #e67e22;
        }
        .error {
            color: #e74c3c;
        }
        .success {
            color: #27ae60;
        }
    </style>
</head>
<body>
<center>
    <font size="6">Informasi Data Barang</font>
    <hr width="320">
    <table border="0">

<?php
require("koneksi.php");

$id_barang = $_POST['id_barang'];
$nama_barang = $_POST['nama_barang'];
$stok = $_POST['stok'];
$harga = $_POST['harga'];

$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];
$folder = "img/";

$target_file = $folder . basename($foto);

// Cek apakah ID Barang sudah ada
$cek_query = "SELECT * FROM barang WHERE id_barang = '$id_barang'";
$cek_result = mysqli_query($koneksi, $cek_query);

if (mysqli_num_rows($cek_result) > 0) {
    echo "<div class='message warning'>⚠️ Data dengan ID Barang <strong>$id_barang</strong> sudah ada di database. Silakan gunakan ID yang berbeda.</div>";
} else {
    // Lanjutkan upload dan simpan
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
$ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

if (!in_array($ext, $allowed_ext)) {
    echo "<div class='message error'>❌ Hanya file gambar yang diizinkan (jpg, jpeg, png, gif).</div>";
    exit;
}

    if (move_uploaded_file($tmp, $target_file)) {
        $sql = "INSERT INTO barang (id_barang, nama_barang, stok, harga, foto)
                VALUES ('$id_barang', '$nama_barang', '$stok', '$harga', '$foto')";
        if (mysqli_query($koneksi, $sql)) {
            echo "<div class='message success'>✅ Data berhasil disimpan.</div>";
        } else {
            echo "<div class='message error'>❌ Gagal menyimpan data: " . mysqli_error($koneksi) . "</div>";
        }
    } else {
        echo "<div class='message error'>❌ Gagal mengupload gambar.</div>";
    }
}
?>

    <div class="button-container">
        <form action="inputbarang.html" method="get" style="display:inline;">
            <button type="submit" class="btn">Tambah Data Baru</button>
        </form>
        <form action="menu.html" method="get" style="display:inline;">
            <button type="submit" class="btn btn-danger">Tidak</button>
        </form>
    </div>

</center>
</body>
</html>
