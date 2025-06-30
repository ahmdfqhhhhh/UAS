<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "belajar";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql = "SELECT * FROM barang";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Barang</title>
  <link rel="icon" type="image/png" href="logostruk.png">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f1f5f9;
      margin: 0;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #1e293b;
      margin-bottom: 20px;
    }

    table {
      border-collapse: collapse;
      width: 90%;
      margin: 0 auto;
      background-color: #ffffff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 16px;
      border-bottom: 1px solid #e2e8f0;
      text-align: center;
    }

    th {
      background-color: #2563eb;
      color: #ffffff;
    }

    tr:hover {
      background-color: #f3f4f6;
    }

    .button-group {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
      flex-wrap: wrap; /* Responsif */
    }

    .btn {
      padding: 12px 24px;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
      text-align: center;
      width: 160px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn.download {
      background-color: #10b981;
    }

    .btn.download:hover {
      background-color: #059669;
    }

    .btn.back {
      background-color: #3b82f6;
    }

    .btn.back:hover {
      background-color: #2563eb;
    }

    .no-data {
      text-align: center;
      color: #9ca3af;
      padding: 20px;
    }

    /* Responsif untuk layar kecil */
    @media (max-width: 600px) {
      .btn {
        width: 100%;
        max-width: 300px;
      }
    }
  </style>
</head>
<body>

  <h2>Data Barang</h2>

  <table>
    <tr>
      <th>ID Barang</th>
      <th>Nama Barang</th>
      <th>Harga</th>
      <th>Stok</th>
    </tr>
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= htmlspecialchars($row["id_barang"]) ?></td>
          <td><?= htmlspecialchars($row["nama_barang"]) ?></td>
          <td>Rp <?= number_format($row["harga"], 0, ',', '.') ?></td>
          <td><?= htmlspecialchars($row["stok"]) ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="4" class="no-data">Tidak ada data barang</td></tr>
    <?php endif; ?>
  </table>

  <div class="button-group">
    <a href="download_barang.php" class="btn download">Download Excel</a>
    <a href="menu.html" class="btn back">Kembali</a>
  </div>

</body>
</html>

<?php mysqli_close($conn); ?>
