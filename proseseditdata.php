<?php
require("koneksi.php");

$pilihan = $_POST['pilihan'];
$id_barang = "";
$nama_barang = "";

if ($pilihan === "id") {
    $id_barang = $_POST['id_barang'];
    $sql = "SELECT * FROM barang WHERE id_barang='$id_barang'";
} else {
    $nama_barang = $_POST['nama_barang'];
    $sql = "SELECT * FROM barang WHERE nama_barang='$nama_barang'";
}

$hasil = mysqli_query($koneksi, $sql);
$row = mysqli_fetch_assoc($hasil);
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data Barang</title>
  <link rel="icon" type="image/png" href="logostruk.png">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #1e293b;
    }

    form {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input[type="text"], input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    input[readonly] {
      background-color: #f9fafb;
    }

    .btn-group {
      margin-top: 20px;
      text-align: center;
    }

    input[type="submit"], input[type="reset"] {
      padding: 10px 20px;
      border: none;
      background-color: #2563eb;
      color: white;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      margin: 0 10px;
    }

    input[type="submit"]:hover {
      background-color: #1e40af;
    }

    input[type="reset"]:hover {
      background-color: #6b7280;
    }

    .not-found {
      text-align: center;
      color: red;
      font-weight: bold;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<?php if ($row): ?>
  <h1>Edit Data Barang</h1>
  <form action="saveeditdata.php" method="post">
    <label>ID Barang</label>
    <input type="text" name="id_barang" value="<?= htmlspecialchars($row['id_barang']) ?>" readonly>

    <label>Nama Barang</label>
    <input type="text" name="nama_barang" value="<?= htmlspecialchars($row['nama_barang']) ?>">

    <label>Stok</label>
    <input type="number" name="stok" value="<?= htmlspecialchars($row['stok']) ?>">

    <label>Harga</label>
    <input type="number" name="harga" value="<?= htmlspecialchars($row['harga']) ?>">

    <div class="btn-group">
      <input type="submit" value="Simpan Perubahan">
      <input type="reset" value="Reset">
    </div>
  </form>
<?php else: ?>
  <p class="not-found">
  Maaf, data dengan 
  <strong>
    <?= ($pilihan === 'id') ? 'ID: ' . htmlspecialchars($id_barang) : 'Nama Barang: ' . htmlspecialchars($nama_barang) ?>
  </strong> tidak ditemukan.
</p>
<?php endif; ?>

</body>
</html>
