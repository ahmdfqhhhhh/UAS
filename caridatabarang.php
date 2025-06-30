<?php
require("koneksi.php");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Pencarian Barang</title>
  <link rel="icon" type="image/png" href="logostruk.png">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9fafb;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #1f2937;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    td {
      padding: 10px;
      vertical-align: top;
      border-bottom: 1px solid #e5e7eb;
    }

    td:first-child {
      font-weight: bold;
      color: #374151;
      width: 30%;
    }

    img {
      margin-top: 10px;
      border-radius: 8px;
      max-width: 100%;
      height: auto;
    }

    .not-found {
      color: red;
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
    }

    .button-group {
      text-align: center;
      margin-top: 30px;
    }

    .btn {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      margin: 0 10px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .btn:hover {
      background-color: #45a049;
    }

    .btn-secondary {
      background-color: #6b7280;
    }

    .btn-secondary:hover {
      background-color: #4b5563;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Hasil Pencarian Barang</h1>
    <hr />

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['id_barang'])) {
            $id_barang = mysqli_real_escape_string($koneksi, $_POST['id_barang']);
            $sql = "SELECT * FROM barang WHERE id_barang = '$id_barang'";
            $keterangan = "ID <strong>" . htmlspecialchars($id_barang) . "</strong>";
        } elseif (!empty($_POST['nama_barang'])) {
            $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
            $sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$nama_barang%'";
            $keterangan = "Nama mengandung <strong>" . htmlspecialchars($nama_barang) . "</strong>";
        } else {
            echo "<p class='not-found'>Input pencarian tidak valid.</p>";
            exit;
        }

        $hasil = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($hasil) > 0) {
            while ($row = mysqli_fetch_assoc($hasil)) {
                $id_barang   = htmlspecialchars($row['id_barang']);
                $nama_barang = htmlspecialchars($row['nama_barang']);
                $stok        = htmlspecialchars($row['stok']);
                $harga       = htmlspecialchars($row['harga']);
                $foto        = htmlspecialchars($row['foto']);

                echo "<table>";
                echo "<tr><td>ID Barang</td><td>: $id_barang</td></tr>";
                echo "<tr><td>Nama Barang</td><td>: $nama_barang</td></tr>";
                echo "<tr><td>Stok</td><td>: $stok</td></tr>";
                echo "<tr><td>Harga</td><td>: Rp " . number_format($harga, 0, ',', '.') . "</td></tr>";

                $gambar_path = "img/$foto";
                echo "<tr><td>Foto</td><td>";
                if (!empty($foto) && file_exists($gambar_path)) {
                    echo "<img src='$gambar_path' alt='Foto Barang'>";
                } else {
                    echo "(Tidak ada foto)";
                }
                echo "</td></tr>";
                echo "</table><br/>";
            }
        } else {
            echo "<p class='not-found'>Maaf, data dengan $keterangan tidak ditemukan.</p>";
        }
    }
    ?>

    <div class="button-group">
      <a href="caridatabarang.html" class="btn">Cari Data Baru</a>
      <a href="menu.html" class="btn btn-secondary">Kembali</a>
    </div>
  </div>
</body>
</html>
