<?php
$koneksi = new mysqli("localhost", "root", "", "belajar");

// Ambil data barang dari database
$barangList = [];
$result = $koneksi->query("SELECT * FROM barang");
while ($row = $result->fetch_assoc()) {
    $barangList[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Pembelian Barang</title>
  <link rel="icon" type="image/png" href="logostruk.png">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f2f2f2;
      padding: 20px;
    }
    .form-container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .barang-group {
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 10px;
      background: #f9f9f9;
      position: relative;
    }
    .barang-group button.remove {
      position: absolute;
      top: 10px;
      right: 10px;
      background: red;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 5px 10px;
      cursor: pointer;
    }
    .qty-wrapper {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }
    .qty-wrapper button {
      background: #007bff;
      color: white;
      border: none;
      padding: 6px 12px;
      font-size: 18px;
      cursor: pointer;
    }
    .qty-wrapper input {
      width: 60px;
      text-align: center;
      margin: 0 5px;
    }
    label {
      display: block;
      margin-top: 10px;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 15px;
    }
    .total-belanja {
      text-align: right;
      font-weight: bold;
      font-size: 16px;
      margin-top: 20px;
    }
    .btn-tambah {
      background: green;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      margin-bottom: 10px;
      cursor: pointer;
    }
    input[type=submit] {
      background: blue;
      color: white;
      padding: 10px 20px;
      border: none;
      width: 100%;
      font-size: 16px;
      border-radius: 6px;
    }
  </style>
</head>
<body>
<div class="form-container">
  <h2>🛒 Form Pembelian Barang</h2>
  <form action="simpan_pembeli.php" method="POST">
    <label>Nama Pengguna:</label>
    <input type="text" name="username" placeholder="Ketik nama pengguna..." required>

    <label>Alamat:</label>
    <textarea name="alamat" required></textarea>

    <label>No HP:</label>
    <input type="text" name="no_hp" required>

    <div id="barang-container">
      <div class="barang-group">
        <button type="button" class="remove" onclick="removeBarang(this)">🗑</button>

        <div class="qty-wrapper">
          <button type="button" onclick="ubahJumlah(this, -1)">-</button>
          <input type="number" name="jumlah[]" value="1" min="1" required>
          <button type="button" onclick="ubahJumlah(this, 1)">+</button>
        </div>

        <label>Nama Barang:</label>
        <select name="id_barang[]" onchange="pilihBarang(this)" required>
          <option value="">-- Pilih Barang --</option>
          <?php foreach ($barangList as $b): ?>
            <option value="<?= $b['id_barang'] ?>" data-harga="<?= $b['harga'] ?>" data-stok="<?= $b['stok'] ?>">
              <?= htmlspecialchars($b['nama_barang']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label>Harga (Rp):</label>
        <input type="number" name="harga[]" readonly>

        <label>Stok Tersedia:</label>
        <input type="text" name="stok_tersedia[]" readonly>
      </div>
    </div>

    <div class="total-belanja">Total Belanja: Rp <span id="total-belanja">0</span></div>

    <button type="button" class="btn-tambah" onclick="tambahBarang()">+ Tambah Barang</button>

    <label>Uang yang dibayarkan (Rp):</label>
    <input type="number" name="uang_bayar" required>

    <input type="submit" value="🧾 Simpan & Cetak Struk">
  </form>
</div>

<script>
const barangData = <?= json_encode($barangList) ?>;

function pilihBarang(select) {
  const group = select.closest('.barang-group');
  const hargaInput = group.querySelector('input[name="harga[]"]');
  const stokInput = group.querySelector('input[name="stok_tersedia[]"]');
  const selected = select.options[select.selectedIndex];
  hargaInput.value = selected.getAttribute('data-harga') || '';
  stokInput.value = selected.getAttribute('data-stok') || '';
  hitungTotal();
}

function ubahJumlah(btn, delta) {
  const input = btn.parentElement.querySelector('input[name="jumlah[]"]');
  let val = parseInt(input.value) || 1;
  val += delta;
  if (val < 1) val = 1;
  input.value = val;
  hitungTotal();
}

function tambahBarang() {
  const container = document.getElementById('barang-container');
  const clone = container.firstElementChild.cloneNode(true);

  clone.querySelector('input[name="jumlah[]"]').value = 1;
  clone.querySelector('select[name="id_barang[]"]').selectedIndex = 0;
  clone.querySelector('input[name="harga[]"]').value = '';
  clone.querySelector('input[name="stok_tersedia[]"]').value = '';

  container.appendChild(clone);
  hitungTotal();
}

function removeBarang(btn) {
  const group = btn.closest('.barang-group');
  const container = document.getElementById('barang-container');
  if (container.children.length > 1) {
    group.remove();
    hitungTotal();
  }
}

function hitungTotal() {
  let total = 0;
  document.querySelectorAll('.barang-group').forEach(group => {
    const jumlah = parseInt(group.querySelector('input[name="jumlah[]"]').value) || 0;
    const harga = parseFloat(group.querySelector('input[name="harga[]"]').value) || 0;
    total += jumlah * harga;
  });
  document.getElementById('total-belanja').innerText = total.toLocaleString('id-ID');
}
</script>
</body>
</html>
