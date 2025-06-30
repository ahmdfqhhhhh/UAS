<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Save Edit Data Barang</title>
  <link rel="icon" type="image/png" href="logostruk.png">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f4f8;
      padding: 40px;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #1d4ed8;
      font-size: 24px;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    td {
      padding: 12px 10px;
      border-bottom: 1px solid #e5e7eb;
    }

    td:first-child {
      font-weight: 600;
      width: 35%;
      color: #374151;
    }

    td:last-child {
      color: #1f2937;
    }

    .message {
      text-align: center;
      margin-top: 25px;
      font-weight: 600;
      font-size: 16px;
    }

    .message.success {
      color: #16a34a;
    }

    .message.error {
      color: #dc2626;
    }

    .button-group {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 30px;
    }

    .button-group form {
      display: inline;
    }

    .btn {
      padding: 12px 24px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-danger {
      background-color: #ef4444;
      color: white;
    }

    .btn-danger:hover {
      background-color: #dc2626;
      transform: scale(1.03);
    }

    .btn-secondary {
      background-color: #6b7280;
      color: white;
    }

    .btn-secondary:hover {
      background-color: #4b5563;
      transform: scale(1.03);
    }

    hr {
      margin: 30px 0;
      border: none;
      border-top: 1px solid #e5e7eb;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Data Barang Telah Diperbarui</h1>
  <hr>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      require("koneksi.php");

      $id_barang    = htmlspecialchars($_POST['id_barang']);
      $nama_barang  = htmlspecialchars($_POST['nama_barang']);
      $stok         = htmlspecialchars($_POST['stok']);
      $harga        = htmlspecialchars($_POST['harga']);

      // Tampilkan data
      echo "<table>";
      echo "<tr><td>ID Barang</td><td>$id_barang</td></tr>";
      echo "<tr><td>Nama Barang</td><td>$nama_barang</td></tr>";
      echo "<tr><td>Stok</td><td>$stok</td></tr>";
      echo "<tr><td>Harga</td><td>Rp " . number_format($harga, 0, ',', '.') . "</td></tr>";
      echo "</table>";

      // Update ke database
      $sql = "UPDATE barang 
              SET nama_barang='$nama_barang', stok='$stok', harga='$harga' 
              WHERE id_barang='$id_barang'";

      $hasil = mysqli_query($koneksi, $sql);

      if ($hasil) {
          echo "<div class='message success'>✅ Data berhasil disimpan ke dalam tabel.</div>";
      } else {
          echo "<div class='message error'>❌ Gagal menyimpan data: " . mysqli_error($koneksi) . "</div>";
      }

      echo "<div class='button-group'>
              <form method='GET' action='editdata.html'>
                  <button type='submit' class='btn btn-danger'>Edit Data Lagi</button>
              </form>
                <form method='GET' action='menu.html'>
                  <button type='submit' class='btn btn-secondary'>Tidak</button>
              </form>
            </div>";

      mysqli_close($koneksi);
  } else {
      echo "<div class='message error'>Akses tidak valid.</div>";
  }
  ?>

  <hr>
</div>

</body>
</html>
