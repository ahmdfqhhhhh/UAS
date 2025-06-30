<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="w3.css">
  <title>Proses Hapus Data Barang</title>
  <link rel="icon" type="image/png" href="logostruk.png">
</head>
<body background="paper.gif">
<center>
  <div class="w3-container">
    <div class="w3-panel w3-blue w3-card-4 w3-round-xxlarge">
      <h1>PROSES HAPUS DATA BARANG</h1>
    </div>

    <div class="w3-panel w3-border w3-card-4 w3-light-blue">
      <hr>
      <?php
      require("koneksi.php");

      $pilihan = $_POST['pilihan'];
      $data_cari = $_POST['data_cari'];

      $sql = "SELECT * FROM barang WHERE $pilihan = '$data_cari'";
      $hasil = mysqli_query($conn, $sql);
      $row = mysqli_fetch_row($hasil);

      if ($row) {
        echo '<form action="delete_barang.php" method="post">';
        echo '<table border="0">';

        do {
          list($id_barang, $nama_barang, $stok, $harga, $foto) = $row;

          echo "<tr><td>ID BARANG</td><td width=280>: $id_barang</td><td rowspan=5><img src='$foto' width='300' height='300'></td></tr>";
          echo "<tr><td>NAMA</td><td>: $nama_barang</td></tr>";
          echo "<tr><td>STOK</td><td>: $stok</td></tr>";
          echo "<tr><td>HARGA</td><td>: $harga</td></tr>";
          echo "<input type='hidden' name='id_barang' value='$id_barang'>";
        } while ($row = mysqli_fetch_row($hasil));

        echo '</table>';
        echo '<hr>';
        echo '<input type="submit" value="Yakin Data Ini Dihapus...!" class="w3-btn w3-deep-orange w3-round-xlarge" style="width:350px">';
        echo '</form>';
      } else {
        echo '
          <div class="w3-panel w3-red w3-round-xxlarge">
            <h1 class="w3-text-white" style="text-shadow:1px 1px 0 #444">
              <b>Maaf, Data Tidak Ditemukan!</b>
            </h1>
          </div>';
      }
      ?>
    </div>
  </div>
</center>
</body>
</html>
